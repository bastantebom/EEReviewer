<?php
//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
	class View{
	
		function createPageHeader($page_title, $jquery, $js, $css){
                    //This will create a page header
                   
			echo $this->displayPageHeader = "<html><head>
                        <meta http-equiv='Content-type' content='text/html; charset=utf-8' />
                        
			<script type='text/javascript' src='$jquery/jquery-1.7.1.js'></script>
			<script type='text/javascript' src='$js/actionHandler.js'></script>
                        <link rel='stylesheet' type='text/css' href='$css/style.css' />

                        <script type='text/javascript' src='$js/jquery.min.js'></script>
                        <script type='text/javascript' src='$js/jquery.js'></script>
			<title>$page_title</title></head>
			<body>";
		}
		
		function createPageFooter(){
                    //This will create page footer
			echo $this->displayPageFooter = "</body></html>";
		}
		
		
		function createForm($name, $action, $method, $content, $id){
                    //this will create <form> 
			$this->displayForm = "<form name='$name' action='$action' method='$method' id='$id'>$content</form>";
			echo $this->displayForm;
		}
		
		function createComponents($controller,$name,$value,$id,$class){
                    //this will create component of diffrent types
			$this->displayComponents = "<input type='$controller' value='$value' name='$name' id='$id' class='$class'/>";
			return $this->displayComponents;
		}
		
		function createDivLayerOpening($name,$id,$class,$content){
                    //this will create an opening div layer
			$this->displayDivLayerOpening = "<div name='$name' id='$id' class='$class'>$content</div>";
			echo $this->displayDivLayerOpening;
		}
                
		function createDivLayerClosing(){
                    //close the div layer
			$this->displayDivLayerClosing = "</div>";
			echo $this->displayDivLayerClosing;
		}
		
		function createParagraph($id,$class,$content){
                    //this will create <p>
			$this->displayParagraph = "<p id='$id' class='$class'>$content</p>";
			return $this->displayParagraph;
		}
		
		function createSpan($id,$class,$content){
                    //this will create <span>
			$this->displaySpan = "<span id='$id' class='$class'>$content</span>";
			return $this->displaySpan;
		}
		
                function createBreakLine(){
                    //this will add <br />
                        $this->displayBreakLine ="</br>";
                        return $this->displayBreakLine;
                }
                
                function dateNow(){
                    return date("Y-m-d");  
                }
                
                function timeNow(){
                  $secondsCount = time();
                  $dateFromTime = date('Y-m-d', $secondsCount);
                  return $dateFromTime;
                }   
	}
?>