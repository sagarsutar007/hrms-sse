<diV class="display_flex_center" id="heder_div" style="justify-content: space-between">
    <div style="display: flex">
        <i class="fa-solid fa-bars" style="font-size: 20px; margin: 10px; cursor: pointer; " id="bar_icon"
        onclick="openClosemenu()"></i>

        <i class="fa-solid fa-bars" style="font-size: 20px; margin: 10px; cursor: pointer; " id="bar_icon2"
        onclick="openClosemenu2()"></i>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
       {{-- <div class="display_flex_center">
        <img src="{{ URL('images/logo.png')}}" id="brand_logo" class="padding_5">
        <h3 class="margin_left_5">Shri Sai Electricals</h3>
    </div> --}}
    </div>


    <div style="display: flex; align-items: center">
        <p style="margin-right: 20px" id="enterFullScreenBtn" onclick="opencloseFullScreen()"><i class="fa-solid fa-arrows-up-down-left-right"></i></p>
        <p id="user_icon" onclick="location.href='{{url('/login')}}'"> <i class="fa-solid fa-arrow-right-from-bracket"></i></p>

    </div>
</diV>


<style>

      #bar_icon2{
            display: none;
        }

    @media only screen and (max-width: 1100px) {
        #bar_icon{
            display: none;
        }

        #bar_icon2{
            display: block;
        }
}
</style>

<script>
    var opencloseFullScreen_count= 0;

    function opencloseFullScreen(){
    if(opencloseFullScreen_count % 2 == 0){
        openFullScreen()
    }else{

       closeFullScreen()
    }
 opencloseFullScreen_count = opencloseFullScreen_count +1 ;
    }

        const fullScreenDiv = document.getElementById('bodyy');
        const enterFullScreenButton = document.getElementById('enterFullScreenBtn');
        const exitFullScreenButton = document.getElementById('exitFullScreenBtn');

        // Function to request full-screen mode
        function openFullScreen() {
            if (fullScreenDiv.requestFullscreen) {
                fullScreenDiv.requestFullscreen();
            } else if (fullScreenDiv.mozRequestFullScreen) { // Firefox
                fullScreenDiv.mozRequestFullScreen();
            } else if (fullScreenDiv.webkitRequestFullscreen) { // Chrome, Safari, Opera
                fullScreenDiv.webkitRequestFullscreen();
            } else if (fullScreenDiv.msRequestFullscreen) { // IE/Edge
                fullScreenDiv.msRequestFullscreen();
            }


        }

        // Function to exit full-screen mode
        function closeFullScreen() {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.mozCancelFullScreen) { // Firefox
                document.mozCancelFullScreen();
            } else if (document.webkitExitFullscreen) { // Chrome, Safari, Opera
                document.webkitExitFullscreen();
            } else if (document.msExitFullscreen) { // IE/Edge
                document.msExitFullscreen();
            }


        }

    </script>



