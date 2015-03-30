<?php
ob_start();
class Model extends View{
    //global $dbcon;
        ////connect to database
	function connectDatabase($host,$user,$pass,$db){
                //Connection with the database
		$this->dbcon = new mysqli($host, $user, $pass, $db);
                return $this->dbcon;
	}
        
        ////closes connection to database
	function closeConnection($conn){
                //Closing Database Connection
		$conn->close();
	}

        ///Authenticate user in login area
        function authenticateUser($conn,$user,$temppass){
                $pass= md5($temppass);
                 $resultAuthUser = $conn->query("SELECT * FROM tbl_user WHERE eer_userName = '$user' and eer_password = '$pass' ");
                 $resultData=$resultAuthUser->fetch_array(MYSQLI_ASSOC);
                 
                 if($resultAuthUser->num_rows == 1){    
                     $_SESSION['username'] = $resultData['eer_userName'];
                     $_SESSION['password'] = $resultData['eer_password'];
                     $_SESSION['name'] = $resultData['eer_fullName'];
                     $_SESSION['uid'] = $resultData['eer_userId'];
                     $_SESSION['exam'] = $resultData['eer_numberTakeOfExam'];
                     $_SESSION['dated'] = $resultData['eer_lastDateExam'];
                      //$_SESSION['utype'] = $resultData['eer_userType'];
                      
                     $type=$resultData['eer_userType'];
                     switch($type){
                         case 1:
                             $_SESSION['utype'] = "Administrator";
                             header("location:../control_panel.php");
                             exit();
                         break;
                     
                         case 2:
                              $_SESSION['utype'] = "Student";
                              header("location:../student_panel.php");
                             exit();
                         break;
                     
                     }
                 
                } 
                else{
                    header("location:../index.php");
                    exit();
                }
        }
        
        /////uploading of student/////
        function uploadNewStudent($conn,$studentNumber,$studentName,$password){
            $message ="";
            if($this->checkUserExist($conn, $studentNumber)==TRUE){
                $conn->query("UPDATE tbl_user SET eer_fullName = '$studentName',  eer_lastDateExam = '' WHERE eer_userId ='$studentNumber'") or Die(mysql_error());
                //$conn->query("DELETE FROM tbl_studentquestion");
           }
            else{
                $conn->query("INSERT INTO tbl_user(eer_userType,eer_userId,eer_userName,eer_password,eer_fullName,eer_numberTakeOfExam,eer_lastDateExam) 
                          VALUES(2,'$studentNumber','$studentNumber','$password','$studentName',0,'')") or Die(mysql_error());
            
               $message = $this->createDivLayerOpening("", "", "msg msg-ok", "<p><strong>Your file was uploaded successfully!</strong></p>");
            }
			
            return $message;
        }
        
        ///add New Category////
        function addCategory($conn,$name,$desc,$id){
            $name = stripslashes($name);
            $desc = stripslashes($desc);
            if($id==0){
                $conn->query("INSERT INTO tbl_category(eer_categoryName,eer_categoryDesc) 
                            VALUES('$name','$desc')") or Die(mysql_error());
                $message = $this->createDivLayerOpening("", "", "msg msg-ok", "<p><strong>Your Category successfully Created!</strong></p>");
            }
            else{
                $conn->query("UPDATE tbl_category SET eer_categoryName = '$name',eer_categoryDesc = '$desc'  WHERE eer_categoryId ='$id'") or Die(mysql_error());
                $message = $this->createDivLayerOpening("", "", "msg msg-ok", "<p><strong>Your Category successfully Updated!</strong></p>");
            }
            return $message;
        }
        
         ///add New Sub Category////
        function addSubCategory($conn,$id,$cid,$name,$desc){
            $name = stripslashes($name);
            $desc = stripslashes($desc);
            $cid = stripslashes($cid);
            if($id==0){
                $conn->query("INSERT INTO tbl_subcategory(eer_subCategoryName,eer_subCategoryDesc,eer_categoryId) 
                            VALUES('$name','$desc','$cid')") or Die(mysql_error());
                //$message= "Insert";
                $message = $this->createDivLayerOpening("", "", "msg msg-ok", "<p><strong>Your Category successfully Created!</strong></p>");
            }
            else{
                
                $conn->query("UPDATE tbl_subcategory SET eer_subCategoryName = '$name',eer_subCategoryDesc = '$desc'  WHERE eer_categoryId ='$cid' AND eer_subCategoryId='$id'") or Die(mysql_error());
                $message = $this->createDivLayerOpening("", "", "msg msg-ok", "<p><strong>Your Sub Category successfully Updated!</strong></p>");
                //$message = "Update";
            }
            return $message;
            //return $desc . $name . $cid . $id . $message;
        }
        
        //////check if the user exist based on student number///
        function checkUserExist($conn,$studentNumber){
            $result=$conn->query("SELECT eer_userId FROM tbl_user WHERE eer_userId = '$studentNumber'");
            if($result->num_rows==1){
                return TRUE;
            }
        }
        
        //////get list of category///
        function getListOfCategory($conn,$id){
            $category = "";
            $result=$conn->query("SELECT * FROM tbl_category");
            while($resultRaw=$result->fetch_array(MYSQLI_ASSOC)){
                if($id==$resultRaw['eer_categoryId']){
                $category = $category.$this->createDivLayerOpening("", "", "categoryBox", "<div class='actionLabel'><input type='text' id='updateCategoryName' value='$resultRaw[eer_categoryName]' style='width: 640px;' /><br /><textarea id='updateCategoryDesc' style='width: 640px'>$resultRaw[eer_categoryDesc]</textarea></div>
                        <p class='actionButton'>
                                <img src='_css/images/save.jpg' alt='$resultRaw[eer_categoryId]' class='saveButton' onclick='updateCategory(this.alt)' border='0' />Update
                        </p>");
                }
                else{
                $cat_id = base64_encode($resultRaw['eer_categoryId']);    
                $category = $category.$this->createDivLayerOpening("", "", "categoryBox", "<p class='spacer'></p><div class='actionLabel'><label class='labelCategoryName'><a href='sub_category.php?category=$cat_id'>$resultRaw[eer_categoryName]</a></label><p class='labelCategoryDesc'>$resultRaw[eer_categoryDesc]</p></div>
                        <p class='actionButton'>
                                <img src='_css/images/del.gif' alt='$resultRaw[eer_categoryId]' class='editUser' onclick='deleteCategory(this.alt)' border='0' />Delete
                                <img src='_css/images/edit.gif' alt='$resultRaw[eer_categoryId]' class='editButton' onclick='readyUpdateCategory(this.alt)' border='0' />Edit
                        </p>");
                }
                
            }
            return $category;
        }
        
        //////get list of sub category///
        function getListOfSubCategory($conn,$sub_id,$cat_id){
            $category = "";
            $result=$conn->query("SELECT * FROM tbl_subcategory WHERE eer_categoryId = '$cat_id' ");
            while($resultRaw=$result->fetch_array(MYSQLI_ASSOC)){
                if($sub_id==$resultRaw['eer_subCategoryId']){
                $category = $category.$this->createDivLayerOpening("", "", "categoryBox", "<div class='actionLabel'><input type='hidden' id='updateci' value='$cat_id' /><input type='text' id='updateSubCategoryName' value='$resultRaw[eer_subCategoryName]' style='width: 640px;' /><br /><textarea id='updateSubCategoryDesc' style='width: 640px'>$resultRaw[eer_subCategoryDesc]</textarea></div>
                        <p class='actionButton'>
                                <img src='_css/images/save.jpg' alt='$resultRaw[eer_subCategoryId]' class='saveButton' onclick='updateSubCategory(this.alt, $cat_id)' border='0' />Update
                        </p>");
                }
                else{
                $sid = base64_encode($resultRaw['eer_subCategoryId']);
                $cid = base64_encode($cat_id);
                //$sid = $resultRaw['eer_subCategoryId'];
                //$cid = $cid;
                $category = $category.$this->createDivLayerOpening("", "", "categoryBox", "<p class='spacer'></p><div class='actionLabel'><label class='labelCategoryName'><a href='question.php?category=$cid&subcategory=$sid'>$resultRaw[eer_subCategoryName]</a></label><p class='labelCategoryDesc'>$resultRaw[eer_subCategoryDesc]</p></div>
                        <p class='actionButton'>
                                <img src='_css/images/del.gif' alt='$resultRaw[eer_subCategoryId]' class='editUser' onclick='deleteSubCategory(this.alt)' border='0' />Delete
                                <img src='_css/images/edit.gif' alt='$resultRaw[eer_subCategoryId]' class='editButton' onclick='readyUpdateSubCategory(this.alt)' border='0' />Edit
                        </p>");
                }
                
            }
            return $category;
        }
        
        /////persist delete category///
        function deleteCategory($conn, $id){
           $conn->query("DELETE FROM tbl_category WHERE eer_categoryId='$id'");
           $error = $this->createDivLayerOpening("", "", "msg msg-error", "<p><strong>Category successfully Deleted!</strong></p>");
           return $error;
        }
        
        /////persist delete sub category///
        function deleteSubCategory($conn, $sub_id, $cat_id){
           $conn->query("DELETE FROM tbl_subcategory WHERE eer_subCategoryId='$sub_id' AND eer_categoryId = '$cat_id'");
           $error = $this->createDivLayerOpening("", "", "msg msg-error", "<p><strong>Category successfully Deleted!</strong></p>");
           return $error;
        }
        
        //////get category name///
        function getCategoryName($conn, $id){
            $result = $conn->query("SELECT eer_categoryId,eer_categoryName FROM tbl_category WHERE eer_categoryId = '$id' ");
            $resultRaw = $result->fetch_array(MYSQLI_ASSOC);
            return trim($resultRaw['eer_categoryName']);
        }
        
        //////get category name///
        function getSubCategoryName($conn, $id){
            $result = $conn->query("SELECT eer_categoryId,eer_categoryName FROM tbl_category WHERE eer_categoryId = '$id' ");
            $resultRaw = $result->fetch_array(MYSQLI_ASSOC);
            return trim($resultRaw['eer_categoryName']);
        }
        
        //////persist question/////
        function addQuestion($conn, $question, $answer, $optionOne, $optionTwo, $optionThree, $category, $difficulty){
           //$model = $question.$answer.$optionOne.$optionTwo.$optionThree.$answer;
           $subcategory  = 24;
           $conn->query("INSERT INTO tbl_question(eer_question,eer_answer,eer_optionOne,eer_optionTwo,eer_optionThree,eer_optionFour,eer_categoryId,eer_subcategoryId,eer_questionDifficulty) 
                                           VALUES('$question','$answer','$optionOne','$optionTwo','$optionThree','$answer','$category','$subcategory','$difficulty')") or Die(mysql_error());
           $message = $this->createDivLayerOpening("", "", "msg msg-ok", "<p><strong>Your Question successfully Added!</strong></p>");
           return $message;
            //return $model;
        }
        
        ////get list of question//
        function getQuestion($conn, $category){
            $content ="";
            $result = $conn->query("SELECT * FROM tbl_question WHERE eer_categoryId = '$category'");
            $head= "<div class='table' style='height:200px; overflow: scroll;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>
                <tr>
                    <th width='13'>Delete</th>
                    <th>Number</th>
                    <th>Question</th>
                    <th>Difficulty</th>
		</tr>
                ";
            $number = 1;
            while($resultRaw = $result->fetch_array(MYSQLI_ASSOC)){
                $diff = $this->getDifficulty($resultRaw['eer_questionDifficulty']);
                $ques=html_entity_decode($resultRaw['eer_question']);
		$content = $content."<tr>
                                <td><img src='_css/images/del.gif' alt='$resultRaw[eer_questionId]' class='editUser' onclick='deleteQuestion(this.alt)' border='0' /></td>
				<td>$number</td>
				<td>$ques</td>
                                <td>$diff</td>
			   </tr>";
            $number++;   
            }
            $foot = "</table></div>";
            return $head.$content.$foot;
        }
        
        //////get difficulty desc////
        function getDifficulty($difficulty){
            $difficultyDesc = "";
            switch ($difficulty) {
                case 1:
                    $difficultyDesc = "Easy";
                break;
            
                case 2:
                    $difficultyDesc = "Moderate";
                break;
            
                case 3:
                    $difficultyDesc = "Difficult";
                break;
            }
            
            return $difficultyDesc;
        }
        
        /////get list of student///
        function getListOfStudent($conn,$param){
            $content = "";
            if($param != "*"){
                $result = $conn->query("SELECT * FROM tbl_user WHERE eer_userType = 2 AND eer_activateExam = 0 AND eer_fullName LIKE '%" .$param. "%' ORDER BY eer_fullName ASC");
                //$result = $conn->query("SELECT * FROM tbl_user WHERE eer_userType = 2 AND eer_activateExam = 0 AND MATCH (eer_userId, eer_fullName) AGAINST('". $param ."')");
            }
            else{
                $result = $conn->query("SELECT * FROM tbl_user WHERE eer_userType = 2 AND eer_activateExam = 0 ORDER BY eer_fullName ASC");
            }
            $head= "<div class='table' id='keyActivator' style='height:200px; overflow: scroll;'><table width='100%' border='0' cellspacing='0' cellpadding='0'>";
             $number = 1;
            while($resultRaw = $result->fetch_array(MYSQLI_ASSOC)){
              if($resultRaw['eer_lastDateExam']!= ""){
              $examDate = date('Y-m-d',$resultRaw['eer_lastDateExam']);
              }
              else{
               $examDate = ""; 
              }
              $content = $content."<tr>
                                <td style='width: 30px;'><input type='checkbox' class='checkbox' name='ticker[]' value='$resultRaw[eer_userId]' /></td>
				<td>$number</td>
                                <td>$resultRaw[eer_userId]</td>
				<td>$resultRaw[eer_fullName]</td>
                                <td>$examDate</td>
                                <td>$resultRaw[eer_numberTakeOfExam]</td>
			   </tr>";
              $number++;     
            }
            $foot = "</table></div>";
            return $head.$content.$foot;
        }
        
        //////activate Exam////
        function onExam($conn, $temp){
          $groupId = explode(".", $temp);
          foreach ($groupId as $studentId) {
              $conn->query("UPDATE tbl_user SET eer_activateExam = 1 WHERE eer_userId = '$studentId'");
          }
           $message = $this->createDivLayerOpening("", "", "msg msg-ok", "<p><strong>Exam successfully activated!</strong></p>");
           return $message;   
        }
        
        //////get student exam/////
        function getExam($conn, $uid){
            $result = $conn->query("SELECT eer_userId, eer_activateExam FROM tbl_user WHERE eer_userId = '$uid'");
            $resultRaw = $result->fetch_array(MYSQLI_ASSOC);
            if($resultRaw['eer_activateExam']==1){
                if($this->checkStudentUnfinised($conn,$uid)== TRUE){
                $exam = $this->createDivLayerOpening("", "", "noExam", "<p class='spacer'></p><div class='actionLabel'>&nbsp;&nbsp;Click the button to start exam<br /><label class='labelCategoryName'><input type='button' id='resumeExam' style='height: 30px; width: 220px;' value='You have unfinnished Exam'></label></div>");
                }
                else{
                $exam = $this->createDivLayerOpening("", "", "categoryBox", "<p class='spacer'></p><div class='actionLabel'>&nbsp;&nbsp;Click the button to start exam<br /><label class='labelCategoryName'><input type='button' id='startExam' style='height: 30px; width: 220px;' value='You have an Active Exam'></label></div>");
                }
            }
            else{
                $exam = $this->createDivLayerOpening("", "", "noExam", "<p class='spacer'></p><div class='actionLabel'><label class='labelCategoryName'><br />&nbsp;You have no Active Exam</label></div>");
                //$category = $this->createDivLayerOpening("", "", "categoryBox", "<p class='spacer'></p><div class='actionLabel'><label class='labelCategoryName'><a href=''>You have an Active Exam</a></label></div>");
            }
            
            return $exam;
        }
        
        /////generate Exam for student///
        function createExam($conn, $studId){
            $question = "";
            $examNumber = $_SESSION['exam'] + 1;
            $result = $conn->query("SELECT * FROM tbl_category");
            while ($resultRaw = $result->fetch_array(MYSQLI_ASSOC)){
                $category = $resultRaw['eer_categoryId'];
                $max = $this->getCountOfQuestion($conn,$resultRaw['eer_categoryId']);
                $moveNext = 1;
                while($moveNext<=$_SESSION['count']){
                   $pickNumber = rand(0, $max-1);///row value of the question not the Id
                   $resultSubCat = $conn->query("SELECT * FROM tbl_question WHERE eer_categoryId = '$category' ");
                       $resultSubCat->data_seek($pickNumber);
                       $row = $resultSubCat->fetch_array(MYSQLI_ASSOC);
                        if($this->checkQuestionExist($conn, $row['eer_questionId'], $examNumber, $studId)!= TRUE){
                           $qId = $row['eer_questionId'];
                           $q = $row['eer_question'];
                           $qa = $row['eer_answer'];
                           $choices = $row['eer_optionOne']."*:x-x:*".$row['eer_optionTwo']."*:x-x:*".$row['eer_optionThree']."*:x-x:*".$row['eer_optionFour'];
                           $rnDm_choices = explode("*:x-x:*", $choices);
                           shuffle($rnDm_choices);
                           $A = $rnDm_choices[0];
                           $B = $rnDm_choices[1];
                           $C = $rnDm_choices[2];
                           $D = $rnDm_choices[3];
                           $conn->query("INSERT INTO tbl_studentquestion(eer_studentId,eer_categoryId,eer_subcategoryId,eer_questionId,eer_question,eer_actualAnswer,eer_isCorrect,eer_statusOfQuestion,eer_examNumber,eer_optionOne,eer_optionTwo,eer_optionThree,eer_optionFour,eer_keyAnswer) 
                                                                  VALUES('$studId','$category',0, '$qId', '$q','',0, 0, ' $examNumber','$A','$B','$C','$D','$qa')");
                           $moveNext++; 
                        }   
                }   
            }
            $today = time();
            $conn->query("UPDATE tbl_user SET eer_numberTakeOfExam = '$examNumber', eer_lastDateExam = '$today' WHERE eer_userId = '$studId'");
           return $this->createDivLayerOpening("", "", "examInstructionBox", "<p class='spacer'>
               </p>
                <div class='actionLabel'>
                    <label style='margin-left: 5px;padding-left: 10px;'>
                    You are about to start the Electrical Engineering Reviewer Exam this exam consist of 9 categories with 28 items each. <br /><br />

                    <b>Before you Begin:</b><br />
                     <p style='text-indent: 5px;'>Required browser: Internet Explorer 7.0 + or Google Chrome or Mozilla Firefox<br />
                    Close other programs, including email</p><br /><br />

                    <b>During the Exam</b><br />
                    <p style='text-indent: 5px;'>The student may not use their textbook, course notes, or receive help from any source.<br />
                    Students must complete the 28 multiple choice question per category this exam consist of 9 categories.<br />
                    Students cannot proceed unless the current question is not being answered.</p><br /><br />

                    <b>Technical Difficulties</b><br />
                    <p style='text-indent: 5px;'>In the event your exam is interrupted, your answers have been saved (but not submitted for grading), follow these instruction to resume taking your exam.<br />
                    Close your browser<br />
                    Login to this URL: Using your User ID and Password</p><br /><br />

                    <b>Click the button to Begin.</b><br /><br />
                    <input class='button' style='margin-left: 10px;' value='begin exam' onclick='getListExamPerCategory();' />
                    </label>
                </div>");
        }
        
        ////modification 8/23/2012////
        function queryListOfExam($conn){
            $test='';
            $opening = "<div class='categoryListing'>";
            $categories = "<h2><b>&nbsp;List of Categories:</b></h2><br /><p>&nbsp;Click a category to start exam</p><br /><br />";
            $result = $conn->query("SELECT * FROM tbl_category");
            while($resultRaw = $result->fetch_array(MYSQLI_ASSOC)){
                $id=$resultRaw['eer_categoryId'];
                //$test = $test.$this->checkThisCategoryFinished($conn,$id)."<br />";
                if($this->checkThisCategoryFinished($conn,$resultRaw['eer_categoryId'])==0){
                    $categories = $categories;
                }
                else{
                     $categories = $categories."&nbsp;&nbsp;<input type='button' style='height: 30px; width: 250px;' value='$resultRaw[eer_categoryName]' onclick='startCategoryExam($resultRaw[eer_categoryId]);'/><br /><br />";
                }
                // $test = $test.$this->checkThisCategoryFinished($conn,$resultRaw['eer_categoryId']);
                 //return $test;
            }
            $closing = "</div>";
            return $opening.$categories.$closing;
           //return $test;
        }
        
        
        function checkThisCategoryFinished($conn,$category){
            $uid = $_SESSION['username'];
            $examNumber = $this->getExamNumber($conn,$uid);
            $result=$conn->query("SELECT * FROM tbl_studentquestion WHERE eer_statusOfQuestion = 0 AND eer_examNumber = '$examNumber' AND eer_categoryId = '$category' AND eer_studentId='$uid'"); 
           return $result->num_rows;
            //return $uid;
        }
        
        
        function getExamNumber($conn,$uid ){
           $result=$conn->query("SELECT * FROM tbl_user WHERE eer_userId = '$uid'"); 
           $resultRaw = $result->fetch_array(MYSQLI_ASSOC);
           return $resultRaw['eer_numberTakeOfExam'];
        }
        
        function deleteQuestion($conn, $id){
           $conn->query("DELETE FROM tbl_question WHERE eer_questionId='$id'");
           $error = $this->createDivLayerOpening("", "", "msg msg-error", "<p><strong>Question successfully Deleted!</strong></p>");
           return $error;
        }
        /////end of modification
        
        
        ///////get count of sub category////
        function getCountOfQuestion($conn,$subCategory){
            $result = $conn->query("SELECT * FROM tbl_question WHERE eer_categoryId = '$subCategory'");
            return $result->num_rows;
        }
        
        //////check if question already been pick up////
        function checkQuestionExist($conn,$questionId, $enumber, $studId){
            $result = $conn->query("SELECT * FROM tbl_studentquestion WHERE eer_questionId = '$questionId' AND eer_examNumber = '$enumber' AND eer_studentId = '$studId'");
            if($result->num_rows == 1){
                return TRUE;
            }
        }
        
        ///check if theres unfinished question
        function checkStudentUnfinised($conn, $uid){
            $result = $conn->query("SELECT * FROM tbl_studentquestion WHERE eer_studentId = '$uid' AND eer_statusOfQuestion = 0 ");
            if($result->num_rows >= 1){
                return TRUE;
            }
            else{
                return FALSE;
            }
        }
        
        function initExam($conn, $uid, $cat_id){
            $result = $conn->query("SELECT * FROM tbl_studentquestion WHERE eer_statusOfQuestion = 0 AND eer_studentId = '$uid' AND eer_categoryId = '$cat_id' ORDER BY eer_studQuestionId ASC");
            $resultRaw = $result->fetch_array(MYSQLI_ASSOC);
            $eNumber = $_SESSION['exam'];
            if($result->num_rows == 0){
                if($this->checkStudentUnfinised($conn,$uid)==FALSE){
                    $conn->query("UPDATE tbl_user SET eer_activateExam = 0 WHERE eer_userId = '$uid'"); 
                }
                return "<h2 style='color: #00CC66'>You already finished the exam for this category to see result click the button below to Print</h2><br /><br />
                    <form action='ReportPerUser.php' method='post' target='_blank'>
                    <input type='hidden' name='studentId' value='$uid' />
                    <input type='hidden' name='examNumberDropDown' value='$eNumber' />
                    <input type='hidden' name='categoryId' value='$cat_id' />
                    <input type='submit' style='margin-left: 10px;width: 125px; height: 25px;' value='generate report' />
                    <a style='float:right;margin-right: 20px;' href='student_panel.php'><h2>&nbsp;Go to Home</h2></a>
                </form>";
            }
            else{
            $subCategoryName = $this->getSubCategoryName($conn, $resultRaw['eer_categoryId']);
            $question_D = html_entity_decode($resultRaw['eer_question']);
            $option_A = html_entity_decode($resultRaw['eer_optionOne']);
            $option_B = html_entity_decode($resultRaw['eer_optionTwo']);
            $option_C = html_entity_decode($resultRaw['eer_optionThree']);
            $option_D = html_entity_decode($resultRaw['eer_optionFour']);
           return $this->createDivLayerOpening("", "", "examInstructionBox", "<p class='spacer'>
               </p>
                <div class='actionLabel'>
                    <label style='margin-left: 5px;padding-left: 10px; font-size: 16px;font-weight: bold;'>
                   <input type='hidden' value='$resultRaw[eer_studQuestionId]' id='studQuestionId' />
                    <h1 style='margin-left: 5px;color: #069ecd'>Category - $subCategoryName</h1><br /><br />
                    <h2 style='margin-left: 5px;'>$question_D</h2><br /><br />
                   <p style='margin-left: 20px;'>
                    <input type = 'radio' style='margin-bottom: 10px;' name ='multipleChoice' onclick='checkAnswer(this.value,$cat_id)' value= '$option_A' /><label>$option_A</label><br />
                    <input type = 'radio' style='margin-bottom: 10px;' name ='multipleChoice' onclick='checkAnswer(this.value,$cat_id)' value= '$option_B' /><label>$option_B</label><br />
                    <input type = 'radio' style='margin-bottom: 10px;' name ='multipleChoice' onclick='checkAnswer(this.value,$cat_id)' value= '$option_C' /><label>$option_C</label><br />
                    <input type = 'radio' name ='multipleChoice' onclick='checkAnswer(this.value,$cat_id)' value= '$option_D' /><label>$option_D</label><br /><br />
                   <span id='resultAnswer'></span>
                    </label>
                   </p>
                </div>");
            //return "Test";
            }
        }
        
        ////check answer///
        function validateAnswer($conn,$actual,$currentQuestion,$category){
            $result = $conn->query("SELECT * FROM tbl_studentquestion WHERE eer_studQuestionId = '$currentQuestion' AND eer_statusOfQuestion = 0 AND eer_keyAnswer = '$actual' AND eer_categoryId='$category' ");
            $resultRaw = $result->fetch_array(MYSQLI_ASSOC);
            if($result->num_rows == 1){
                $answer = 1;
                $answerStatus = "<h2 style='color: #00CC66'>Correct</h2><br /><br /><input class='button' style='margin-left: 10px;' value='next question' onclick='startExam($category)' />";
            }
            else{
                $answer = 0;
                $result = $conn->query("SELECT * FROM tbl_studentquestion WHERE eer_studQuestionId = '$currentQuestion'");
                $resultRaw = $result->fetch_array(MYSQLI_ASSOC);
                $answerStatus = "<h2 style='color: #FF9966'>Wrong - the correct Answer is $resultRaw[eer_keyAnswer]</h2><br /><br /><input class='button' style='margin-left: 10px;' value='next question' onclick='startExam($category)' />";
            }
            $conn->query("UPDATE tbl_studentquestion SET eer_statusOfQuestion = 1, eer_actualAnswer = '$actual', eer_isCorrect = '$answer' WHERE eer_studQuestionId = '$currentQuestion'");
            return $answerStatus;
        }
        
        ///get report list///
        function listOfReportPerStudent($conn, $studentId){
            $examNumberReport = "";
            $examNumberReport1 = "";
            $result = $conn->query("SELECT DISTINCT eer_examNumber FROM tbl_studentquestion WHERE eer_studentId = '$studentId'");
            $resultCat = $conn->query("SELECT * FROM tbl_category");
            if($result->num_rows >= 1){
            $form="<form action='ReportPerUser.php' method='post' target='_blank'><input type='hidden' name='studentId' value='$studentId' />";
            $startSelect="<select style='margin: 10px 0px 10px 10px;' id='examNumberDropDown' name='examNumberDropDown'><option value=''>select exam to print report</option>";
           
                while($resultRaw = $result->fetch_array(MYSQLI_ASSOC)){
                    $examNumberReport = $examNumberReport."<option value='$resultRaw[eer_examNumber]'>Exam Number $resultRaw[eer_examNumber]</option>";
                }
            
            $endSelect = "</select>";
            
            $startSelect1="<select style='margin: 10px 0px 10px 10px;' id='examNumberDropDown' name='categoryId'><option value=''>all category</option>";
           
                while($resultRaw = $resultCat->fetch_array(MYSQLI_ASSOC)){
                    $examNumberReport1 = $examNumberReport1."<option value='$resultRaw[eer_categoryId]'>$resultRaw[eer_categoryName]</option>";
                }
            
            $endSelect1 = "</select>";
            
            
            $endForm ="<input type='submit' class='submit' style='margin-left: 10px;width: 125px; height: 25px;' value='generate report'/></form>";
            return $form.$startSelect.$examNumberReport.$endSelect.$startSelect1.$examNumberReport1.$endSelect1.$endForm;
            }
            else{
                return "";
            }
        }
        
        function getListOfStudentDropDown($conn){
            $body = "";
            $result = $conn->query("SELECT eer_userId, eer_fullName FROM tbl_user WHERE eer_userType = 2 AND eer_numberTakeOfExam > 0");
            $head = "<select name='studentId'><option value=''>--select student--</option>";
            while ($resultRaw = $result->fetch_array(MYSQLI_ASSOC)){
                $body = $body."<option value='$resultRaw[eer_userId]'>$resultRaw[eer_fullName]</option>";
            }
            $tail= "</select>";
            return $head.$body.$tail;
        }
		
        function updatePassword($conn,$old,$new,$confirm){
            if($new == $confirm){
		if($this->checkMatchOldPassword($conn,$old)==TRUE){
		$new = md5($new);
		$conn->query("UPDATE tbl_user SET eer_password = '$new' WHERE eer_userId ='$_SESSION[uid]'") or Die(mysql_error());
		$message = $this->createDivLayerOpening("", "", "msg msg-ok", "<p><strong>Password successfully updated!</strong></p>");
		}
		else{
                    $message = $this->createDivLayerOpening("", "", "msg msg-error", "<p><strong>Old password did not match!</strong></p>");
		}
				//$message = "";
		}
		else{
			$message = $this->createDivLayerOpening("", "", "msg msg-error", "<p><strong>New Password and Confirmed Password didn't match!</strong></p>");
		}
	return $message;
	}
		
	function checkMatchOldPassword($conn,$old){
	$old = md5($old);
	$result = $conn->query("SELECT * FROM tbl_user WHERE eer_userId = '$_SESSION[uid]' AND eer_password = '$old' ");
            if($result->num_rows == 1){
                return TRUE;
            }
	}
             
}                
?> 