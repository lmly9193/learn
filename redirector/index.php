<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Video Embeding System</title>
	<meta name="description" content="Video Embeding System">
	<meta name="viewport" content="width=device-width">
	<link rel="icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAMAAAAoLQ9TAAAAA3NCSVQICAjb4U/gAAAACXBIWXMAAABvAAAAbwHxotxDAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAFFQTFRF////AAAAGwAALQEBPgICOAICSCEhTwMDUkVFUkZGVD4+VQMDXx0dghERkgUFmQUFmo+PnpaWogUFpQUFrgYGuQYGugYG0wcH1QcH6Ojo////VIe8EAAAAAZ0Uk5TAAhV1OLk46qZIwAAAFJJREFUGFdjYMAEjEgAyGViZkECzEwMzBIogJmBFUwLiUMFWCECwhxsoigC/IKSXLyoAlJSAjz4BdC0CHOiGYpsLdxhfOzs3CJizJhOx/AcOgAA5zwM2aaHDyMAAAAASUVORK5CYII=">
	<script src='jwplayer/jwplayer.js'></script>
	<script src='jwplayer/provider.html5.js'></script>

	<link rel="stylesheet" href='css/fullscreen.css'>
	<link rel="stylesheet" href='css/tube.css'>
</head>
<body>
	<?php include_once "script.php";?>
	<div id="videoContainer">LOADING...</div>
	<script>var playerInstance=jwplayer("videoContainer");playerInstance.setup({"playlist":<?php playlist($_GET["playlist"]);?>,"mute":"false","autostart":"false","nextupoffset":"-10","repeat":"false","abouttext":"技術提供","aboutlink":"https://github.com/lmly9193","controls":"true","localization":{"nextUp":"接下來","playlist":"影片清單"},"height":"100%","width":"100%","displaytitle":"true","displaydescription":"true","timesliderabove":"true","primary":"html5","preload":"none","skin":{"url":"css/tube.css","name":"tube","active":"red","inactive":"white"},"logo":{"file":"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACAAAAAgCAMAAABEpIrGAAAAA3NCSVQICAjb4U/gAAAACXBIWXMAAADdAAAA3QFwU6IHAAAAGXRFWHRTb2Z0d2FyZQB3d3cuaW5rc2NhcGUub3Jnm+48GgAAAL1QTFRF////AAAAAAAAAAAAAAAABgAABwAABAAAAgAAHQEBJAEBAAAAAwEBBgAABgMDBwUFDgsLEAsLEQEBEQsLEwEBGBMTGBQUHwcHKQcHKygoNQYGPjg4Pzw8TQgIVVJSWQMDYwMDZgQEcAQEcgQEcwQEdAQEfAQEiwUFjIyMkgUFkwUFlgUFmQUFoAUFo6OjpQUFsAYGuQYGvAYGwAYGwgYGzAcH0QcH0tLS0wcH1AcH1QcH4eHh7e3t/v7+////506o6gAAAAt0Uk5TAAMQKSy4w/L5/f2Ug/EpAAAArklEQVQ4y72TxxKCMBBAF2mB2HsviCjYxQZq/v+znHhzJLsHR981byZlXwD+gpZToL2WDYtxBcwyAHTmBmsFgct0MJ0kVZI4Jth+iuDbwENMCPmb4HknVIhqjdYWE8a9+zA/OWOCEJtye4cK4tYvzq6YIB6LUjfGBCEuncFXArUFdUjimsRDRZUm/tTksLLH/RlMXC9IqofRVAaTkdxqLlmm+6NMjoyWzJ7+OD/nCQkviYvQ3qcwAAAAAElFTkSuQmCC","hide":"false","link":"https://github.com/lmly9193","margin":"8","position":"top-left"},"sharing":{"heading":"分享","link":"<?php urlhttps();?>","code":"<iframe src='<?php urlhttps();?>' width='640' height='480' frameborder='0' scrolling='auto'></iframe>","sites":["facebook","twitter","tumblr","googleplus","reddit","linkedin","interest","email"]}});playerInstance.addButton("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAADdcAAA3XAUIom3gAAAAHdElNRQfhAhwOMiXdKXT8AAAAoUlEQVQoz4WRvRGCUBAGF4fhVWAVJIaWYTlWQTHKTwsSGZnSgKGZyRqA+MDn+GV3u3M3c4cHB6OA+7jOqdjSE+dBDwR2AKgXvmKwmyamBIOt2nlNChNuDV4SgsFmxJAQLKzVxgBg6X4hTLge8bs5Cxae1dpiZvEKC0/q+YPXwlE9xXgU8rmqgCp7ft8secnPhA1/kjmw5faDltxZv3uRwcMLdtjIVcxHYWwAAAAldEVYdGRhdGU6Y3JlYXRlADIwMTctMDItMjhUMTQ6NTA6MzcrMDE6MDATThFcAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDE3LTAyLTI4VDE0OjUwOjM3KzAxOjAwYhOp4AAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAAASUVORK5CYII=","在新視窗中開啟",function(){window.open("https://drive.google.com/file/d/"+playerInstance.getPlaylistItem()["fileId"]+"/preview","_blank");},"preview");playerInstance.addButton("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAADdcAAA3XAUIom3gAAAAHdElNRQfhAhwOKDF33lpaAAAAbElEQVQoz72PoQ2AMBQFrwSBbMIAKCZgGRJGQTMKO7AECZ5hHoa2If0Fx8l3Zx5EdChwpLXigx+CGtQzAODj6jUCsLsTUKNNFpuacNBKkjaTp86SXD8SW8ekrO/kTVs40MJUsKuba6ClKwQtXHK6ch70HrrzAAAAJXRFWHRkYXRlOmNyZWF0ZQAyMDE3LTAyLTI4VDE0OjQwOjQ5KzAxOjAwiDq82AAAACV0RVh0ZGF0ZTptb2RpZnkAMjAxNy0wMi0yOFQxNDo0MDo0OSswMTowMPlnBGQAAAAZdEVYdFNvZnR3YXJlAHd3dy5pbmtzY2FwZS5vcmeb7jwaAAAAAElFTkSuQmCC","下載",function(){window.open("https://docs.google.com/uc?id="+playerInstance.getPlaylistItem()["fileId"]+"&export=download","_blank");},"download");</script>
	<!--<?php echo "記憶體使用量: ".memory_get_usage()." (byte)";?>-->
</body>
</html>
