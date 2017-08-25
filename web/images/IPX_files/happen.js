
var count = 1;

var happenList = [

    {content:"<p class='greenBorder'><strong  class='ipxgreen_txt'>Agency Century21</strong><br>In Melbourne, Just Downloaded <br>Townhouses in Victoria, AU</p>",className:'Melbourne'},
    {content:"<p class='blueBorder'>Townhouse Project <br>in Brunswick, VIC<br><strong  class='ipxblue_txt'>Vendor Just Uploaded</strong></p>",className:'Brunswick'},
    {content:"<p class='greenBorder'><strong  class='ipxgreen_txt'>Agent Amy</strong><br>In Shenzhen, Just Reserved <br>Apartments in New South Wales, AU </p> ",className:'Shenzhen'},
    {content:"<p class='blueBorder'>House & Land Project <br>in Point Cook, VIC<br><strong  class='ipxblue_txt'>Vendor Updated Incentives</strong></p>",className:'PointCook'},
    {content:"<p class='greenBorder'><strong  class='ipxgreen_txt'>Agent KingLong Wong</strong><br>In Hongkong, Just Shared <br>Apartments in Queensland, AU'</p>",className:'HongKong'},
    {content:"<p class='blueBorder'>Apartment Project <br>in Sydney, NSW<br><strong  class='ipxblue_txt'>Vendor Just Edited</strong></p>",className:'Rosebery'},
    {content:"<p class='greenBorder'><strong  class='ipxgreen_txt'>Agent Yun Cao</strong><br>In Nantong, Just Viewed <br>Apartments in California, US</p>",className:'Nantong'},
    {content:"<p class='blueBorder'>Apartment Project<br>In Melbourne, VIC<br><strong  class='ipxblue_txt'>Vendor Just Updated Pricelist</strong></p>",className:'Melbourne'},
    {content:"<p class='greenBorder'><strong  class='ipxgreen_txt'>Agent Qun He</strong><br>In Shanghai, Just Viewed <br>Apartments in Victoria, AU</p>",className:'Shanghai'},
    {content:"<p class='blueBorder'>Townhome Project <br>in Los Angeles, CA<br><strong  class='ipxblue_txt'>Vendor Just Uploaded</strong></p>",className:'LosAngeles'},
    {content:"<p class='greenBorder'><strong  class='ipxgreen_txt'>Agency AiJia Realty</strong><br>In Qingdao, Just Downloaded <br>Houses in California, US</p>",className:'Qingdao'},
    {content:"<p class='blueBorder'>Family House Project <br>in Irvine, CA<br><strong  class='ipxblue_txt'>Vendor Just Edited</strong></p>",className:'Irvine'},
    {content:"<p class='greenBorder'><strong  class='ipxgreen_txt'>Agency ShuangDing International</strong><br>In Beijing, Downloaded <br>Houses in Florida, US</p>",className:'Beijing'},
    {content:"<p class='blueBorder'>Resort Investment <br>in Orlando, FL<br><strong  class='ipxblue_txt'>Vendor Just Updated Pricelist</strong></p>",className:'Orlando'},
    {content:"<p class='greenBorder'><strong  class='ipxgreen_txt'>Agency KW Realty</strong><br>In Shanghai, Just Downloaded <br>Apartments in Southampton, UK</p>",className:'Shanghai'},
    {content:"<p class='blueBorder'>Condo Project <br>in Miami, FL<br><strong  class='ipxblue_txt'>Vendor Just Edited</strong></p>",className:'Miami'},
    {content:"<p class='greenBorder'><strong  class='ipxgreen_txt'>Agent Steve Harrison</strong><br>In Los Angeles, Just Viewed <br>Houses in California, US </p>",className:'LosAngeles'},
    {content:"<p class='blueBorder'>Apartment Project <br>in Manchester<br><strong  class='ipxblue_txt'>Vendor Just Uploaded</strong></p>",className:'Manchester'},
    {content:"<p class='greenBorder'><strong  class='ipxgreen_txt'>Agent YiHe Wang</strong><br>In Xi’An, Just Viewed <br>Apartments in London, UK</p>",className:'XiAn'},
    {content:"<p class='blueBorder'>Apartment Project <br>in London<br><strong  class='ipxblue_txt'>Vendor Updated Pricelist</strong></p>",className:'London'},
    {content:"<p class='greenBorder'><strong  class='ipxgreen_txt'>Agency First National</strong><br>In Sydney, Just Downloaded <br>Apartments in Queensland, AU </p>",className:'Sydney'},
    {content:"<p class='blueBorder'>Apartment Project <br>in Birmingham<br><strong  class='ipxblue_txt'>Vendor Just Edited</strong></p>",className:'Birmingham'},
    {content:"<p class='greenBorder'><strong  class='ipxgreen_txt'>Agent Kai Loon Leong</strong><br>In Kuala Lumpur, Just Viewed <br>Apartments in Manchester, UK </p>",className:'KualaLumpur'},
    {content:"<p class='blueBorder'>Apartment Project <br>in London<br><strong  class='ipxblue_txt'>Vendor Updated Project Progress</strong></p>",className:'London'},

  
];
var happen = happenList[0];
var interval =1;
function inner(status){
    if(status =='start'){
        interval = setInterval(function () {
            if (count < happenList.length){
                happen = happenList[count];
                count++
                
            }else{
                happen = happenList[0]
                count = 1;
            }
            setData(happen)
                
        }, 5000);
    }else{
        clearInterval(interval);
        interval = setInterval(function () {
            if (count < happenList.length){
                happen = happenList[count];
                count++
                
            }else{
                happen = happenList[0]
                count = 1;
            }
            setData(happen)
                
        }, 5000);
    }
   

}

function prev(){
    if(count==1){
      var data =   happenList[happenList.length-1]
        setData(data)
        count=happenList.length;
    }else{
       var data =  happenList[count-2]
        setData(data)
        count--
    }
    inner("stop")
    
    
}

function setData(data){
    $('#happenText').html(data.content);
    $('#mapList').attr("class","world_map_bg "+data.className);
    $('#mapMoblieList').attr("class","world_map_bg "+data.className);
}

function next(){
    if(count==happenList.length){
        var data = happenList[0];
        setData(data)
        count=1;
    }else{
        var data = happenList[count];
        setData(data)
        count++
    }
    inner("stop")
}



$(document).ready(function(){
    inner("start");
    setData(happen)
    // document.getElementById("happen").innerHTML=happen;

	
});