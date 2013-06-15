function getRequest(){
	var req = false;
	try{
		req = new XMLHttpRequest();
	} catch(e){
		try{
			req = new ActiveXObject("Msxm12.XMLHTTP");
		}
		catch(e){
			try{
				req = new ActiveXObject("Microsoft.XMLHTTP");
			}catch(e){
				return false;
			}
		}
	}
	return req;
}



function change(location){
var title = document.getElementById('musictitle');
title.innerHTML = ""+location;
var music = document.getElementById('music');
if(!!music.canPlayType('audio/ogg') === true){
	location = location+'.ogg';
}
else{
	location = location+'.mp3';
}
music.src=('/music/playlist/'+location);
music.load();
music.play();
document.getElementById('downloadLink').href=("https://mercuryq.net/music/playlist/"+location);
document.getElementById('playlistButton').style.visibility='visible';
//music.addEventListener('ended',randomSong,false);
}
function randomSong(){
	var nextSong = document.getElementById('select1').options;
	nextSong = nextSong[Math.floor(Math.random()*nextSong.length)].value;
	change(nextSong);
}
function changeVideo(location){
	var video = document.getElementById('video');
	video.src=('videos/'+location);
	video.load();
}	
function replaceStyle(selector, display){
		var n = document.querySelectorAll(selector);
		for (var i = 0; i< n.length;i++){
			n[i].style.display = display;
		}
}
