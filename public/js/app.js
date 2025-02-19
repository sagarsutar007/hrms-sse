
   
   
   function show_menu_items(){
    document.getElementById("side_bar_main_Div").style.width = "270px";
    document.getElementById("div1").style.display = "none";
    document.getElementById("div2").style.display = "block";
    }
    function hide_menu_items(){
        document.getElementById("side_bar_main_Div").style.width = "70px";
    document.getElementById("div1").style.display = "block";
    document.getElementById("div2").style.display = "none"; 
    }


var count = 1;
function openClosemenu(){
    if(count %2 == 0 ){
        hoverBox =  document.getElementById("side_bar_main_Div");
        document.getElementById("side_bar_main_Div").style.width="70px";
        document.getElementById("space_div").style.width="80px";
        hide_menu_items()
        document.getElementById("side_bar_main_Div").classList.remove('pointer_event_none');
    }else{
        document.getElementById("side_bar_main_Div").style.width="270px";
        document.getElementById("space_div").style.width="315px";
        hoverBox =  document.getElementById("side_bar_main_Div");
        show_menu_items()
        document.getElementById("side_bar_main_Div").classList.add('pointer_event_none');
    }
    count++
}


function loade_animation() {
    document.getElementById("loader_div").style.display="none";
  }

  function hide_animation() {
    document.getElementById("loader_div").style.display="none";
  }
  function show_animation() {
    document.getElementById("loader_div").style.display="flex";
  }

  var count2 = 2;

  function openClosemenu2(){
    if(count2 %2 == 0 ){
        document.getElementById("side_bar_main_Div").style.display="flex";
        document.getElementById("div1").style.display="flex";
        document.getElementById("side_bar_main_Div").style.width="270px";
        document.getElementById("side_bar_main_Div").style.background="#343A40";
        document.getElementById("side_bar_main_Div").style.height="100vh";
       
        show_menu_items()
       
    }else{
        document.getElementById("side_bar_main_Div").style.display="none";
        document.getElementById("div1").style.display="none";
        document.getElementById("side_bar_main_Div").style.width="0px";
        document.getElementById("side_bar_main_Div").style.background="#343A40";
        document.getElementById("side_bar_main_Div").style.height="100vh";
       
        hide_menu_items()
       
    }
    count2++

  }






















