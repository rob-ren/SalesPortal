<?php
/**
 * Created by PhpStorm.
 * User: robert
 * Date: 23/8/17
 * Time: 3:21 PM
 */

namespace AppBundle\Controller;

use DatabaseBundle\Business\ProjectBusinessModel;
use DatabaseBundle\Business\ProjectMetaBusinessModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CalculatorController extends Controller
{
    /**
     * render to the investment calculator page
     *
     * @param $project_id
     * @return Response
     */
    public function goProjectCalculatorAction($project_id)
    {
        // get user information & bm
        $account = $this->getUser() ? $this->getUser() : null;
        if ($account != null) {
            $account = $account->convertToArray();
        }
        $project_bm = $this->getProjectBusinessModel();
        $project = $project_bm->loadById($project_id);

        // convert project to array

        return $this->render('AppBundle:Default:investment_calculator.html.twig', array(
            'user' => $account,
            'project' => $project->convertToArray()
        ));
    }

    /**
     * @return Response
     */
    public function goProjectCalculatorPublicAction()
    {
        // get user info
        $account = $this->getUser() ? $this->getUser() : null;
        if ($account != null) {
            $account = $account->convertToArray();
        }
        return $this->render('AppBundle:Default:investment_calculator.html.twig', array(
            'user' => $account
        ));
    }

    /**
     * get project business model
     *
     * @return ProjectBusinessModel
     */
    public function getProjectBusinessModel()
    {
        return $this->get("project_business");
    }

    /**
     * get project meta business model
     *
     * @return ProjectMetaBusinessModel
     */
    public function getProjectMetaBusinessModel()
    {
        return $this->get("project_meta_business");
    }

    /**
     * @return Response
     */
    public function calculateInvestmentPublicAction()
    {
        // get value from request
        $account = $this->getUser() ? $this->getUser() : null;
        if ($account != null) {
            $account = $account->convertToArray();
        }
        // get value from request
        $property_price = $this->getRequest()->get("price") ? $this->getRequest()->get("price") : 400000;
        $loan_percentage = $this->getRequest()->get("loan_percentage") ? $this->getRequest()->get("loan_percentage") : 50;
        $loan_interest_rate = $this->getRequest()->get("loan_interest_rate") ? $this->getRequest()->get("loan_interest_rate") : 4.5;
        $year = $this->getRequest()->get("year") ? $this->getRequest()->get("year") : 1;
        $body_corp = $this->getRequest()->get("body_corp") ? $this->getRequest()->get("body_corp") : 3000;
        $legal_fee = $this->getRequest()->get("legal_fee") ? $this->getRequest()->get("legal_fee") : 880;
        $accounting_fee = $this->getRequest()->get("accounting_fee") ? $this->getRequest()->get("accounting_fee") : 600;
        $council_rate = $this->getRequest()->get("council_rate") ? $this->getRequest()->get("council_rate") : 1000;
        $stamp_duty = $this->getRequest()->get("stamp_duty") >= 0 ? $this->getRequest()->get("stamp_duty") : 3000;
        $firb_surcharge = $this->getRequest()->get("firb_surcharge") >= 0 ? $this->getRequest()->get("firb_surcharge") : 0;
        $client_type = $this->getRequest()->get("client_type") ? $this->getRequest()->get("client_type") : 'firb';
        $property_type = $this->getRequest()->get("property_type") ? $this->getRequest()->get("property_type") : 'investment_property';
        $first_home = $this->getRequest()->get("first_home") ? $this->getRequest()->get("first_home") : 'no';
        $state = $this->getRequest()->get("state") ? $this->getRequest()->get("state") : '';
        $water_rate = $this->getRequest()->get("water_rate") ? $this->getRequest()->get("water_rate") : 700;
        $rent_weekly = $this->getRequest()->get("rent_weekly") ? $this->getRequest()->get("rent_weekly") : $property_price * 0.05 / 52;
        $annual_growth_rate = $this->getRequest()->get("annual_growth_rate") ? $this->getRequest()->get("annual_growth_rate") : 7;

        $result = $this->investmentCalculator($property_price, $loan_percentage, $loan_interest_rate, $year, $body_corp, $legal_fee, $accounting_fee, $council_rate, $stamp_duty, $firb_surcharge, $water_rate, $rent_weekly, $annual_growth_rate);
        $result ['client_type'] = $client_type;
        $result ['first_home'] = $first_home;
        $result ['firb_surcharge'] = $firb_surcharge;
        $result ['property_type'] = $property_type;
        $result ['state'] = $state;
        return $this->render('AppBundle:Default:investment_report.html.twig', array(
            'user' => $account,
            'investment_result' => $result
        ));
    }

    /**
     * @param $property_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function calculateInvestmentAction($project_id)
    {
        // get value from request
        $account = $this->getUser() ? $this->getUser() : null;
        $project_bm = $this->getProjectBusinessModel();
        $project = $project_bm->loadById($project_id);

        $loan_percentage = $this->getRequest()->get("loan_percentage") ? $this->getRequest()->get("loan_percentage") : 50;
        $loan_interest_rate = $this->getRequest()->get("loan_interest_rate") ? $this->getRequest()->get("loan_interest_rate") : 4.5;
        $year = $this->getRequest()->get("year") ? $this->getRequest()->get("year") : 1;
        $body_corp = $this->getRequest()->get("body_corp") ? $this->getRequest()->get("body_corp") : 3000;
        $legal_fee = $this->getRequest()->get("legal_fee") ? $this->getRequest()->get("legal_fee") : 880;
        $accounting_fee = $this->getRequest()->get("accounting_fee") ? $this->getRequest()->get("accounting_fee") : 600;
        $council_rate = $this->getRequest()->get("council_rate") ? $this->getRequest()->get("council_rate") : 1000;
        $stamp_duty = $this->getRequest()->get("stamp_duty") >= 0 ? $this->getRequest()->get("stamp_duty") : 3000;
        $firb_surcharge = $this->getRequest()->get("firb_surcharge") >= 0 ? $this->getRequest()->get("firb_surcharge") : 0;
        $client_type = $this->getRequest()->get("client_type") ? $this->getRequest()->get("client_type") : 'firb';
        $property_type = $this->getRequest()->get("property_type") ? $this->getRequest()->get("property_type") : 'investment_property';
        $first_home = $this->getRequest()->get("first_home") ? $this->getRequest()->get("first_home") : 'no';
        $state = $this->getRequest()->get("state") ? $this->getRequest()->get("state") : '';
        $water_rate = $this->getRequest()->get("water_rate") ? $this->getRequest()->get("water_rate") : 700;
        $rent_weekly = $this->getRequest()->get("rent_weekly") ? $this->getRequest()->get("rent_weekly") : $project->getMinPrice() * 0.05 / 52;
        $annual_growth_rate = $this->getRequest()->get("annual_growth_rate") ? $this->getRequest()->get("annual_growth_rate") : 7;

        $result = $this->investmentCalculator($project->getMinPrice(), $loan_percentage, $loan_interest_rate, $year, $body_corp, $legal_fee, $accounting_fee, $council_rate, $stamp_duty, $firb_surcharge, $water_rate, $rent_weekly, $annual_growth_rate);
        $result ['client_type'] = $client_type;
        $result ['first_home'] = $first_home;
        $result ['firb_surcharge'] = $firb_surcharge;
        $result ['property_type'] = $property_type;
        $result ['state'] = $state;

        if ($account != null) {
            $account = $account->convertToArray();
        }
        return $this->render('AppBundle:Default:investment_report.html.twig', array(
            'user' => $account,
            'investment_result' => $result,
            'project' => $project->convertToArray()
        ));
    }

    /**
     * investment calculator function
     *
     */
    public function investmentCalculator($property_price, $loan_percentage, $loan_interest_rate, $year, $body_corp, $legal_fee, $accounting_fee, $council_rate, $stamp_duty, $firb_surcharge, $water_rate, $rent_weekly, $annual_growth_rate)
    {
        $result = array();
        // get input parameter
        $result['price'] = $property_price;
        $result['loan_percentage'] = $loan_percentage;
        $result['loan_interest_rate'] = $loan_interest_rate;
        $result['year'] = $year;
        $result['body_corp'] = $body_corp;
        $result['legal_fee'] = $legal_fee;
        $result['accounting_fee'] = $accounting_fee;
        $result['council_rate'] = $council_rate;
        $result['stamp_duty'] = $stamp_duty;
        $result['firb_surcharge'] = $firb_surcharge;
        $result['water_rate'] = $water_rate;
        $result['rent_weekly'] = $rent_weekly;
        $result['annual_growth_rate'] = $annual_growth_rate;

        // calculate investment
        $result['annual_rent_rate'] = $result['rent_weekly'] * 52 / $result['price'];
        $result['out_of_pocket'] = $result['price'] * (1 - $result['loan_percentage'] / 100);
        $result['total_loan'] = $result['price'] * $result['loan_percentage'] / 100;
        $result['total_loan_interest'] = $result['total_loan'] * $result['loan_interest_rate'] / 100 * $result['year'];
        $result['interest_per_week'] = $result['total_loan_interest'] / $result['year'] / 52;
        $result['interest_per_month'] = $result['total_loan_interest'] / $result['year'] / 12;
        $result['misc_fee_total'] = ($result['body_corp'] + $result['council_rate'] + $result['water_rate']) * $result['year'] + $result['accounting_fee'] + $result['legal_fee'] + $result['stamp_duty'] + $result['firb_surcharge'];
        $result['rental_income_with_compound'] = 0;
        for ($i = 0; $i < $result['year']; $i++) {
            $result['property_value_per_year'][] = $result['price'] * pow((1 + $result['annual_growth_rate'] / 100), $i);
        }
        for ($i = 0; $i < $result['year']; $i++) {
            $result['rental_income_per_year'][] = $result['price'] * $result['annual_rent_rate'] * pow((1 + $result['annual_growth_rate'] / 100), $i);
            $result['rental_income_with_compound'] = $result['rental_income_with_compound'] + $result['price'] * $result['annual_rent_rate'] * pow((1 + $result['annual_growth_rate'] / 100), $i);

            // calculate total return for each year
            $result['total_loan_interest_year'] = $result['total_loan'] * $result['loan_interest_rate'] / 100 * ($i + 1);
            $result['misc_fee_total_year'] = ($result['body_corp'] + $result['council_rate'] + $result['water_rate']) * ($i + 1) + $result['accounting_fee'] + $result['legal_fee'] + $result['stamp_duty'] + $result['firb_surcharge'];
            $result['total_out_of_pocket_year'] = $result['out_of_pocket'] + $result['total_loan_interest_year'] + $result['misc_fee_total_year'];
            $result['total_expenses_year'] = $result['out_of_pocket'] + $result['total_loan'] + $result['total_loan_interest_year'] + $result['misc_fee_total_year'];
            $result['total_income_year'] = $result['rental_income_with_compound'] + $result['price'] * pow((1 + $result['annual_growth_rate'] / 100), $i + 1);
            $result['total_profit_year'] = $result['total_income_year'] - $result['total_expenses_year'];
            $result['total_return_year'][] = $result['total_profit_year'] / $result['total_out_of_pocket_year'] * 100;
            $result['total_return_year_average'][] = $result['total_profit_year'] / $result['total_out_of_pocket_year'] * 100 / ($i + 1);
        }
        $result['income_average_per_week'] = $result['rental_income_with_compound'] / $result['year'] / 52;
        $result['income_average_per_month'] = $result['rental_income_with_compound'] / $result['year'] / 12;
        $result['est_market_value'] = $result['price'] * pow((1 + $result['annual_growth_rate'] / 100), $result['year']);
        $result['total_expenses'] = $result['out_of_pocket'] + $result['total_loan'] + $result['total_loan_interest'] + $result['misc_fee_total'];
        $result['total_out_of_pocket'] = $result['out_of_pocket'] + $result['total_loan_interest'] + $result['misc_fee_total'];
        $result['total_income'] = $result['rental_income_with_compound'] + $result['est_market_value'];
        $result['total_profit'] = $result['total_income'] - $result['total_expenses'];
        $result['total_return'] = $result['total_profit'] / $result['total_out_of_pocket'] * 100;
        $result['average_annual_return'] = $result['total_return'] / $result['year'];
        $result['cashflow_per_year'] = ($result['rental_income_with_compound'] - $result['total_loan_interest'] - ($result['body_corp'] + $result['council_rate'] + $result['water_rate']) * $result['year']) / $result['year'];
        $result['cashflow_per_week'] = $result['cashflow_per_year'] / 52;
        $result['cash_after_refinance'] = $result['est_market_value'] * $result['loan_percentage'] / 100 - $result['total_loan'];
        $result['loan_interst_first_year'] = $result['total_loan'] * $result['loan_interest_rate'] / 100;
        $result['misc_fee_yearly'] = $result['body_corp'] + $result['council_rate'] + $result['water_rate'];
        $result['total_expenses_first_year'] = $result['out_of_pocket'] + $result['accounting_fee'] + $result['legal_fee'] + $result['stamp_duty'] + $result['firb_surcharge'];
        $result['cashflow_fisrt_year'] = $result['rental_income_per_year'][0] - $result['loan_interst_first_year'] - $result['misc_fee_yearly'];
        return $result;
    }
}