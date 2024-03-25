<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Looping HTML Audio from JSON</title>
</head>
<body>

<audio id="audioPlayer" controls onended="this.play()">
  Your browser does not support the audio element.
</audio>

<script>

// Data JSON berisi daftar URL audio
var audioData = [
  { "url": "<?php echo base_url(); ?>assets/audio/sound1.mp3" }
];

// Mendapatkan URL audio dari data JSON sesuai dengan indeks
var audioUrl = audioData[0].url;

// Memainkan audio
var audio = document.getElementById('audioPlayer');
audio.src = audioUrl;
audio.play();
console.log('Playing audio: ' + audioUrl);

</script>

</body>
</html>

