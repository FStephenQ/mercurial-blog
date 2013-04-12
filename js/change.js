function change(location){
var title = document.getElementById('musictitle');
title.innerHTML = location;
var music = document.getElementById('music');
music.src=('music/playlist/'+location);
music.load();
music.play();
music.addEventListener('ended',randomSong,false);
}
function randomSong(){
	var nextSong = document.getElementById('select1').options;
	nextSong = nextSong[Math.floor(Math.random()*nextSong.length)].value;
	change(nextSong);
}
