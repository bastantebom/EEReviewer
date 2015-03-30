<?php
//Created by: Jayson V. Ilagan
//Software Developer: Ivoclar Vivadent Inc.
//Copyright: 2012
require "generateView.php";
require "generateModel.php";

class Controller extends Model {
    
    function __construct() {
        //Initialize Database Connection
        $this->dbcon = $this->connectDatabase(HOST, USERNAME, PASSWORD, DATABASE_NAME);
    }
    
    ////check user password and username///
    function checkUser($user,$pass){
        $usertemp = htmlentities(strip_tags($user));
        $passtemp = htmlentities(strip_tags($pass));
        echo $this->authenticateUser($this->dbcon,$usertemp,$passtemp);       
    }
    
    ///upload new student///
    function uploadStudent($studentNumber,$studentName,$password){
        if(!empty($studentNumber) || !empty($studentName) || !empty($password)){
            $studentNumber = htmlentities(strip_tags($studentNumber));
            $studentName = htmlentities(strip_tags($studentName));
            $password = htmlentities(strip_tags($password));
            $this->uploadNewStudent($this->dbcon,$studentNumber,$studentName,$password);
        }
    }
    
    ////save new Category///
    function saveCategory($name,$desc){
        if(!empty($name) && !empty($desc)){
           $name = htmlentities(addslashes(strip_tags($name)));
           $desc = htmlentities(addslashes(strip_tags($desc)));
           //echo $name."".$desc;
           $id = 0;
           echo $this->addCategory($this->dbcon, $name, $desc, $id);
        }
    }
    
     ////save new Sub Category///
    function saveSubCategory($cid,$name,$desc){
        if(!empty($name) && !empty($desc) && !empty($cid)){
           $cid = htmlentities(addslashes(strip_tags($cid)));
           $name = htmlentities(addslashes(strip_tags($name)));
           $desc = htmlentities(addslashes(strip_tags($desc)));
           //echo $name."".$desc;
           $id = 0;
           echo $this->addSubCategory($this->dbcon,$id,$cid,$name, $desc);
        }
    }
    
    //////update category//////
     function updateCategory($name,$desc, $id){
        if(!empty($name) && !empty($desc)){
           $name = htmlentities(addslashes(strip_tags($name)));
           $desc = htmlentities(addslashes(strip_tags($desc)));
           //echo $name."".$desc;
           //$id = 0;
           echo $this->addCategory($this->dbcon, $name, $desc, $id);
        }
    }
    
    //////update sub category//////
     function updateSubCategory($id, $cat_id, $name, $desc){
        if(!empty($name) && !empty($desc)){
           $name = htmlentities(addslashes(strip_tags($name)));
           $desc = htmlentities(addslashes(strip_tags($desc)));
           //echo $name."".$desc;
           //$id = 0;
           echo $this->addSubCategory($this->dbcon,$id,$cat_id,$name,$desc);
        }
    }
    
    //////get list of category////
    function retrieveCategory(){
        $id = 0;
        echo $this->getListOfCategory($this->dbcon,$id);
    } 
    
    //////get list of sub category////
    function retrieveSubCategory($cid){
        $sub_id = 0;
        echo $this->getListOfSubCategory($this->dbcon,$sub_id,$cid);
    } 
    
    /////prepare update category//////
    function readyUpdateCategory($id){
        echo $this->getListOfCategory($this->dbcon,$id);
    } 
    
    /////prepare update sub category//////
    function readyUpdateSubCategory($sub_id, $cat_id){
        echo $this->getListOfSubCategory($this->dbcon,$sub_id, $cat_id);
    } 
    
    /////delete category////
    function removeCategory($id){
        echo $this->deleteCategory($this->dbcon,$id);
    }
    
    /////delete sub category////
    function removeSubCategory($sub_id,$cat_id){
        echo $this->deleteSubCategory($this->dbcon,$sub_id,$cat_id);
    }
   
    //////get the category name////
    function retrieveCategoryName($id){
       $id = base64_decode($id);
       return $this->getCategoryName($this->dbcon, $id);
    }
    
    //////get the sub category name////
    function retrieveSubCategoryName($id){
       $id = base64_decode($id);
       return $this->getSubCategoryName($this->dbcon, $id);
    }
    
    /////get question////
    function retrieveQuestion($categoryId){
        return $this->getQuestion($this->dbcon, $categoryId);
    }
    
    ///////save Question////
    function saveQuestion($question, $answer, $optionOne, $optionTwo, $optionThree, $category, $difficulty){
        $question = htmlentities(addslashes(strip_tags($question)));
        $answer = htmlentities(addslashes(strip_tags($answer)));
        $optionOne = htmlentities(addslashes(strip_tags($optionOne)));
        $optionTwo = htmlentities(addslashes(strip_tags($optionTwo)));
        $optionThree = htmlentities(addslashes(strip_tags($optionThree)));
        //return "GO";
        return $this->addQuestion($this->dbcon, $question, $answer, $optionOne, $optionTwo, $optionThree, $category, $difficulty);
       // return "Controller";
    }
    
    ////get list of student////
    function retrieveStudent($param){
        $param = addslashes(strip_tags($param));
        return $this->getListOfStudent($this->dbcon, $param);
    }
    
    ////activate Exam///
    function activateExam($temp){
        //$studentId = explode(".", $temp);
        return $this->onExam($this->dbcon,$temp);
    }
    
    ////retrieve Exam in student panel///
    function retrieveExam($uid){
        return $this->getExam($this->dbcon,$uid);
    }
    
    ////generate Exam////
    function generateExam($studId){
        return $this->createExam($this->dbcon,$studId);
    }
    
    function beginExam($studId,$category){
        echo $this->initExam($this->dbcon,$studId,$category);
    }
    
    function checkAnswer($actualAnswer, $currentQuestion, $category){
        echo $this->validateAnswer($this->dbcon,$actualAnswer,$currentQuestion, $category);
    }
    
    function getExamResultPerStudent($studId){
        echo $this->listOfReportPerStudent($this->dbcon,$studId);
    }
    
    function retrieveListOfStudents(){
        echo $this->getListOfStudentDropDown($this->dbcon);
    }
	
    function changePassword($old, $newpass, $confirm){
	echo $this->updatePassword($this->dbcon,$old, $newpass, $confirm);
    }
    
    /////modification 8/23/2012 get list of category//////
    function getListOfExam(){
        echo $this->queryListOfExam($this->dbcon);
        //echo "Test";
    }
    
    function removeQuestion($questionId){
        echo $this->deleteQuestion($this->dbcon,$questionId);
    }
}

?>