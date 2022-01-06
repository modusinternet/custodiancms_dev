<?php
header("Content-Type:text/html; charset=UTF-8");
header("Expires: on, 01 Jan 1970 00:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if($_SERVER["SCRIPT_NAME"] != "/ccmsusr/index.php") {
	echo "This script can NOT be called directly.";
	exit;
}
?><!DOCTYPE html>
<html lang="{CCMS_LIB:_default.php;FUNC:ccms_lng}">
	<head>
		<title><?= $CFG["DOMAIN"];?> | User | Dashboard</title>
		{CCMS_TPL:head-meta.html}
	</head>
	<style>
		{CCMS_TPL:/_css/head-css.html}

		p{margin:0 0 20px}

		/*
		.cssGrid-Dashboard-01>{grid-area:c1}
		.cssGrid-Dashboard-01>{grid-area:c2}
		*/

		.cssGrid-Dashboard-01{
			display:grid;
			grid-gap:1em;
			/*
			grid-template-areas:
				"c1"
				"c2"
			*/
		}

		.modal{
			background-color:var(--cl0);
			border:1px solid var(--cl2-tran);
			border-radius:6px;
			box-shadow:2px 2px 5px 0px rgba(0,0,0,.2);
			margin-bottom:20px
		}

		.modal>div{padding:10px 20px}

		.modal>div:first-child{
			background-color:var(--cl4);
			border-radius:6px 6px 0 0;
			color:var(--cl0)
		}

		#ccms_news_items{padding-left:30px}
		#ccms_news_items li{margin-bottom:10px}

		/* 824px or larger. Pixel Xl Landscape resolution is 411 x 823. */
		/* 875px or larger. Pixel Xl Landscape resolution is 411 x 823. */
		@media only screen and (min-width: 875px){
			.cssGrid-Dashboard-01{
				grid-template-areas:
					"c1 c2"
			}
		}
	</style>
	<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
		let navActiveItem = ["nav-dashboard"];
		let navActiveSub = [];
	</script>
	<body>
		<main style="padding:20px 20px 20px 0">
			<h1 style="border-bottom:1px dashed var(--cl3)">Dashboard</h1>
			<p>This section is still under development, but if you come across any unresolved issues please let us know at: <a class="oj" href="mailto:info@custodiancms.org?subject=unresolved+issue+report">info@custodiancms.org</a></p>

			<div class="modal">
				<div>Security Logs</div>
				<div>
					<p>List of sessions and or form calls, found in the 'ccms_log' table, that failed.</p>
					<?php
						$qry = $CFG["DBH"]->prepare("SELECT * FROM `ccms_log`;");
						if($qry->execute()) {
							while($row = $qry->fetch()) {
								echo "<p>" . $row["date"] . ", " . $row["ip"] . ", " . $row["url"] . ", " . $row["log"] . "</p>\n";
							}
						} else {
							echo "<p>No records found.</p>\n";
						}
					?>







					<div id="example-table"></div>







				</div>
			</div>

			<div class="cssGrid-Dashboard-01">
				<div class="modal">
					<div>System Info</div>
					<div>
						<p>Server Name: <?= $_SERVER["SERVER_NAME"];?></p>
						<p>Document Root: <?=$_SERVER["DOCUMENT_ROOT"];?></p>
						<p>System Address: <?= $_SERVER["SERVER_ADDR"];?></p>
						<p>Web Server: <?php $a = explode(" ",$_SERVER["SERVER_SOFTWARE"]);echo $a[0];?></p>
						<p>PHP Version: <?= phpversion();?></p>
						<p>PHP Memory Limit: <?= ini_get("memory_limit");?></p>
						<p>MySQL Version: <?= $CFG["DBH"]->getAttribute(PDO::ATTR_SERVER_VERSION);?></p>
					</div>
				</div>

				<div class="modal">
					<div>News From CustodianCMS.org
						<svg id="ccms_news_reload" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="width:28px;position:relative;float:right;top:5px;cursor:pointer">
							<title>Reload</title>
							<path fill="#fff" d="M19.91,15.51H15.38a1,1,0,0,0,0,2h2.4A8,8,0,0,1,4,12a1,1,0,0,0-2,0,10,10,0,0,0,16.88,7.23V21a1,1,0,0,0,2,0V16.5A1,1,0,0,0,19.91,15.51ZM15,12a3,3,0,1,0-3,3A3,3,0,0,0,15,12Zm-4,0a1,1,0,1,1,1,1A1,1,0,0,1,11,12ZM12,2A10,10,0,0,0,5.12,4.77V3a1,1,0,0,0-2,0V7.5a1,1,0,0,0,1,1h4.5a1,1,0,0,0,0-2H6.22A8,8,0,0,1,20,12a1,1,0,0,0,2,0A10,10,0,0,0,12,2Z"/></svg>
					</div>
					<div id="ccms_news_items">
						<p>Nothing to see at the moment.</p>
					</div>
				</div>
			</div>

			<div class="modal">
				<div>License Info</div>
				<div>
					@Version
					<p style="margin-left:20px;">
						{CCMS_LIB:_default.php;FUNC:ccms_version} (Release Date: {CCMS_LIB:_default.php;FUNC:ccms_release_date})
					</p>
					@Copyright
					<p style="margin-left:20px;">
						&copy; {CCMS_LIB:_default.php;FUNC:ccms_dateYear} assigned by Vincent Hallberg of <a class='oj' href="https://custodiancms.org" rel="noopener" target="_blank">custodiancms.org</a> and <a class='oj' href="https://modusinternet.com" rel="noopener" target="_blank">modusinternet.com</a>
					</p>
					<span style="margin:0 20px">License (MIT)</span>
					<p>Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:</p>
					<p>The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.</p>
					<p>THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.</p>
				</div>
			</div>


			<ul>
				<li>HTML Minify</li>
				<li>Templates in Database Cache</li>
				<li>Clear Cache</li>
				<li>Backup/Restore</li>
				<li>Password Recovery attempts currently in the ccms_password_recovery table</li>
			</ul>


			{CCMS_TPL:/footer.html}
		</main>

		{CCMS_TPL:/body-head.php}

		<script nonce="{CCMS_LIB:_default.php;FUNC:ccms_csp_nounce}">
			{CCMS_TPL:/_js/footer-1.php}

			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/custodiancms.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);

			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/metisMenu-3.0.6.min.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);

			var l=document.createElement("link");l.rel="stylesheet";
			l.href = "/ccmsusr/_css/tabulator.5.0.10.min.css";
			var h=document.getElementsByTagName("head")[0];h.parentNode.insertBefore(l,h);

			function loadJSResources() {
				loadFirst("/ccmsusr/_js/jquery-3.6.0.min.js", function() {
					loadFirst("/ccmsusr/_js/metisMenu-3.0.7.min.js", function() {
						loadFirst("/ccmsusr/_js/custodiancms.js", function() {
							loadFirst("/ccmsusr/_js/jquery-validate-1.19.3.min.js", function() {
								loadFirst("/ccmsusr/_js/tabulator.5.0.10.min.js", function() {



									/* user_dropdown START */
									/* When the user clicks on the svg button add the 'show' class to the dropdown box below it. */
									$("#user_dropdown_btn").click(function() {
										$("#user_dropdown_list").addClass("show");
									});

									/* Hide dropdown menu on click outside */
									$(document).on("click", function(e){
										if(!$(e.target).closest("#user_dropdown_btn").length){
											$("#user_dropdown_list").removeClass("show");
										}
									});
									/* user_dropdown END */







//define data
var tabledata = [
	{id:1, name:"Oli Bob", progress:12, location:"United Kingdom", gender:"male", rating:1, col:"red", dob:"14/04/1984", car:1, lucky_no:5, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
	{id:2, name:"Mary May", progress:1, location:"Germany", gender:"female", rating:2, col:"blue", dob:"14/05/1982", car:true, lucky_no:10, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
	{id:3, name:"Christine Lobowski", progress:42, location:"France", gender:"female", rating:0, col:"green", dob:"22/05/1982", car:"true", lucky_no:12, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
	{id:4, name:"Brendon Philips", progress:100, location:"USA", gender:"male", rating:1, col:"orange", dob:"01/08/1980", car:false, lucky_no:18, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
	{id:5, name:"Margret Marmajuke", progress:16, location:"Canada", gender:"female", rating:5, col:"yellow", dob:"31/01/1999", car:false, lucky_no:33, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
	{id:6, name:"Frank Harbours", progress:38, location:"Russia", gender:"male", rating:4, col:"red", dob:"12/05/1966", car:1, lucky_no:2, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
	{id:7, name:"Jamie Newhart", progress:23, location:"India", gender:"male", rating:3, col:"green", dob:"14/05/1985", car:true, lucky_no:63, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
	{id:8, name:"Gemma Jane", progress:60, location:"China", gender:"female", rating:0, col:"red", dob:"22/05/1982", car:"true", lucky_no:72, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
	{id:9, name:"Emily Sykes", progress:42, location:"South Korea", gender:"female", rating:1, col:"maroon", dob:"11/11/1970", car:false, lucky_no:44, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
	{id:10, name:"James Newman", progress:73, location:"Japan", gender:"male", rating:5, col:"red", dob:"22/03/1998", car:false, lucky_no:9, lorem:"Lorem ipsum dolor sit amet, elit consectetur adipisicing "},
];

//Create Date Editor
var dateEditor = function(cell, onRendered, success, cancel){
    //cell - the cell component for the editable cell
    //onRendered - function to call when the editor has been rendered
    //success - function to call to pass the successfuly updated value to Tabulator
    //cancel - function to call to abort the edit and return to a normal cell

    //create and style input
    var cellValue = luxon.DateTime.fromFormat(cell.getValue(), "dd/MM/yyyy").toFormat("yyyy-MM-dd"),
    input = document.createElement("input");

    input.setAttribute("type", "date");

    input.style.padding = "4px";
    input.style.width = "100%";
    input.style.boxSizing = "border-box";

    input.value = cellValue;

    onRendered(function(){
        input.focus();
        input.style.height = "100%";
    });

    function onChange(){
        if(input.value != cellValue){
            success(luxon.DateTime.fromFormat(input.value, "yyyy-MM-dd").toFormat("dd/MM/yyyy"));
        }else{
            cancel();
        }
    }

    //submit new value on blur or change
    input.addEventListener("blur", onChange);

    //submit new value on enter
    input.addEventListener("keydown", function(e){
        if(e.keyCode == 13){
            onChange();
        }

        if(e.keyCode == 27){
            cancel();
        }
    });

    return input;
};

/*
var table = new Tabulator("#example-table", {
	height:"300px",
	data:tabledata, //assign data to table
	layout:"fitDataStretch",
	autoColumns:true,
	pagination:"local",
	paginationSize:4,
	paginationSizeSelector:[2, 4, 8, 16],
});
*/

//Build Tabulator
var table = new Tabulator("#example-table", {
	height:"300px",
	data:tabledata, //assign data to table
	columns:[
		{title:"Name", field:"name", width:150, editor:"input"},
		{title:"Location", field:"location", width:130, editor:"autocomplete", editorParams:{allowEmpty:true, showListOnEmpty:true, values:true}},
		{title:"Progress", field:"progress", sorter:"number", hozAlign:"left", formatter:"progress", width:140, editor:true},
		{title:"Gender", field:"gender", editor:"select", editorParams:{values:{"male":"Male", "female":"Female", "unknown":"Unknown"}}},
		{title:"Rating", field:"rating",  formatter:"star", hozAlign:"center", width:100, editor:true},
		{title:"Date Of Birth", field:"dob", hozAlign:"center", sorter:"date", width:140, editor:dateEditor},
		{title:"Driver", field:"car", hozAlign:"center", editor:true, formatter:"tickCross"},
	],
	pagination:"local",
	paginationSize:4,
	paginationSizeSelector:[2, 4, 8, 16],
	layout:"fitColumns",
});







								});
							});
						});
					});
				});
			}







			const ccms_news_href = 'https://custodiancms.org/cross-origin-resources/news.php?ccms_token=';
			const ccms_ttl = 3600; // seconds, ie: 3600 = 1 hour

			function ccms_news_generate_token() {
				return Math.floor(1000000000000000 + Math.random() * 9000000000000000).toString(36).substr(0, 10);
			}

			function ccms_get_news_xhr() {
				const now = new Date()
				const ccms_ttl_2 = ccms_ttl*1000;

				var xhr = new XMLHttpRequest();
				/* Its necessary to call the custodiancms.org website with a token in your URL because you might be running a serviceworker on your site which want's to try and cache everything.  So to prevent it from pulling a previous call from the cache instead of getting it fresh we change the URL a little each time.  This ofcourse means your cache will eventually fill with outdatted calls to the news feed but we'll have to look into it down the road to see if there is anything more we can do to improve this process later. */
				var ccms_news_href_2 = ccms_news_href + ccms_news_generate_token();
				xhr.open('GET', ccms_news_href_2, true);
				xhr.onreadystatechange = function() {
					if(xhr.readyState === 4) {
						ccms_news_inject(xhr.responseText);
						const temp = {
							expiry: now.getTime() + ccms_ttl_2,
							value: xhr.responseText,
						}
						localStorage.setItem("ccms_news", JSON.stringify(temp))
					}
				}
				xhr.send();
			}

			function ccms_get_news() {
				const jsonItem = localStorage.getItem("ccms_news");
				const item = JSON.parse(jsonItem);
				const now = new Date();

				// compare the expiry time of the item with the current time
				if(now.getTime() > item.expiry) {
					// If the item is expired, delete the item from storage and return null
					localStorage.removeItem("ccms_news");
					ccms_get_news_xhr();
					return;
				}
				ccms_news_inject(item.value);
			}

			function ccms_news_inject(text) {
				var content = document.getElementById("ccms_news_items");
				if(content){
					content.innerHTML = text;
				}
			}

			var localStorageSupport = function() {
				try {
					localStorage.setItem('test', 'test');
					localStorage.removeItem('test');
					return true;
				} catch(e) {
					return false;
				}
			}

			if(localStorageSupport()) {
				if(localStorage.ccms_news) {
					ccms_get_news();
				} else {
					ccms_get_news_xhr();
				}
			}

			document.getElementById("ccms_news_reload").addEventListener("click", () => {
				localStorage.removeItem("ccms_news");
				ccms_get_news_xhr();
			});
		</script>
	</body>
</html>
