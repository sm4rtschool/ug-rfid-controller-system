<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Sound | SILOKERNF</title>

</head>
<body>

  <!--
  <audio id="sound1" preload class="songs">
      <source src="<?php echo base_url(); ?>assets/audio/sound1.mp3" type="audio/mpeg" />
  </audio>
  <audio id="sound2" preload class="songs">
      <source src="<?php echo base_url(); ?>assets/audio/sound2.mp3" type="audio/mpeg" />
  </audio>
  <audio id="sound3" preload class="songs">
      <source src="<?php echo base_url(); ?>assets/audio/sound3.mp3" type="audio/mpeg" />
  </audio>
-->

  <div class="container">

    <div class="page-header">
      <h1>Sound</h1>
    </div>

  </div>

  <iframe src="<?php echo base_url(); ?>assets/audio/sound3.mp3" allow="autoplay">

  <script type="text/javascript">

    //setInterval(playSnd, 5000);

    setInterval(function(){ 
      console.log('playing sound every 5s');
      playSnd();
    }, 5000);

    //alert('play cuy');
    var sounds = new Array(new Audio("<?php echo base_url(); ?>assets/audio/sound3.mp3"), new Audio("<?php echo base_url(); ?>assets/audio/sound2.mp3"));
    var i = -1;
    playSnd();

    function playSnd() {
        i++;
        if (i == sounds.length) return;
        sounds[i].addEventListener('ended', playSnd);
        sounds[i].play();
    }

  </script>

</body>

</html>
