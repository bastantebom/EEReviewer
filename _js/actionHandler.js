////save New Category/////
function saveCategory(security){
   var categoryName = $("#categoryName").val();
   var categoryDesc = $("#categoryDesc").val();
   var categoryId = $("#categoryId").val();
   //alert(categoryDesc + categoryName + categoryId);
   if(categoryName == "" || categoryDesc == ""){
        alert("Please fill the both field!");
    }
   else{
      if(categoryId != "root"){
          //alert("Sub");
        $.post("_action/action_AddSubCategory.php",{security:security, categoryId:categoryId, categoryName:categoryName, categoryDesc:categoryDesc},
            
                      function(data){ 
                          $('#categoryName').val("");
                          $('#categoryDesc').val("");
                          refreshCategoryList();
                          $(".messageListener").html(data);
                      });
        return false;  
      }
 
      else{
        $.post("_action/action_AddCategory.php",{security:security, categoryName:categoryName, categoryDesc:categoryDesc},
            
                      function(data){ 
                          $('#categoryName').val("");
                          $('#categoryDesc').val("");
                          refreshCategoryList();
                            
                          $(".messageListener").html(data);
                      });
       return false;
      }
    }
}
/////refresh category list////
function refreshCategoryList(){
  var categoryId = $("#categoryId").val();
  //alert(categoryId);
    if(categoryId == "root"){
     $.post("_action/action_RefreshCategoryList.php",{categoryId:categoryId},
                        function(data){ 
                            $("#categoryList").html(data);
                        });
         return false;
    }
    
    else{
     $.post("_action/action_RefreshSubCategoryList.php",{categoryId:categoryId},
                        function(data){ 
                            $("#categoryList").html(data);
                        });
     return false;  
    }
}


/////CATEGORY/////

//////delete category////
function deleteCategory(id){
    var r=confirm("Are you sure you want delete this Category?");
        if (r==true){
            $.post("_action/action_DeleteCategory.php",{id:id},
            
            function(data){
                refreshCategoryList();
                 $(".messageListener").html(data);
            });
            return false;
        }
        else{
            return false;
        }
}

///////prepare Update category////
function readyUpdateCategory(id){
    //alert();
    $.post("_action/action_ReadyUpdate.php",{id:id},
            
            function(data){
                //alert(data);
                $("#categoryList").html(data);
            });
            return false;
}

function updateSubCategory(id,cat_id){
    //alert(id);
    
   var categoryName = $("#updateSubCategoryName").val();
   var categoryDesc = $("#updateSubCategoryDesc").val();
   var categoryId = cat_id;
   
   //alert(target);
   //alert(categoryDesc +" "+ categoryName +" "+ categoryId);
   if(categoryName == "" || categoryDesc == ""){
        alert("Please fill the both field!");
    }
   else{
       //alert(target);
        //alert(categoryDesc + target + categoryName);
      
          //alert("");
        $.post("_action/action_UpdateSubCategory.php",{id:id, categoryId:categoryId, categoryName:categoryName, categoryDesc:categoryDesc},
            
                      function(data){ 
                          $('#categoryName').val("");
                          $('#categoryDesc').val("");
                          refreshCategoryList();
                          $(".messageListener").html(data);
                      });
        return false;  
      }
      
}

/////persist update Category///
function updateCategory(id){
   // alert("");
   var categoryName = $("#updateSubCategoryName").val();
   var categoryDesc = $("#updateSubCategoryDesc").val();
   var categoryId = $("#updateSubCategoryId").val();
   
   //alert(target);
   //alert(categoryDesc + categoryName);
   if(categoryName == "" || categoryDesc == ""){
        alert("Please fill the both field!");
    }
   else{
       //alert(target);
        //alert(categoryDesc + target + categoryName);
      if(categoryId != "root"){
          
        $.post("_action/action_UpdateSubCategory.php",{id:id, categoryId:categoryId, categoryName:categoryName, categoryDesc:categoryDesc},
            
                      function(data){ 
                          $('#categoryName').val("");
                          $('#categoryDesc').val("");
                          refreshCategoryList();
                          $(".messageListener").html(data);
                      });
        return false;  
      }
      else{
        $.post("_action/action_UpdateCategory.php",{id:id, categoryName:categoryName, categoryDesc:categoryDesc},
            
                        function(data){ 
                            refreshCategoryList();
                            $(".messageListener").html(data);
                        });
         return false;  
        }
       }  
}

/////SUB CATEGORY/////
//
//////delete category////
function deleteSubCategory(sub_id){
    var categoryId = $("#categoryId").val();
    
    var r=confirm("Are you sure you want delete this Sub Category?");
        if (r==true){
            $.post("_action/action_DeleteSubCategory.php",{sub_id:sub_id, categoryId:categoryId},
            
            function(data){
                refreshCategoryList();
                 $(".messageListener").html(data);
            });
            return false;
        }
        else{
            return false;
        }
}

///////prepare Update sub category////
function readyUpdateSubCategory(sub_id){
    var categoryId = $("#categoryId").val();
    //alert(categoryId + sub_id);
    $.post("_action/action_ReadySubUpdate.php",{sub_id:sub_id, categoryId:categoryId},
            
            function(data){
                $("#categoryList").html(data);
            });
            return false;
}

/////persist update///
function updateCategory(id){
   var categoryName = $("#updateCategoryName").val();
   var categoryDesc = $("#updateCategoryDesc").val();
   
   //alert(target);
   //alert(categoryDesc + categoryName);
   if(categoryName == "" || categoryDesc == ""){
        alert("Please fill the both field!");
    }
   else{
       //alert(target);
        //alert(categoryDesc + target + categoryName);
        $.post("_action/action_UpdateCategory.php",{id:id, categoryName:categoryName, categoryDesc:categoryDesc},
            
                        function(data){ 
                            refreshCategoryList();
                            $(".messageListener").html(data);
                        });
         return false;
    }
}


///////save questionaire//////
function saveQuestion(security){
    var question = $('#question').val();
    var answer = $('#answer').val();
    var optionOne = $('#optionOne').val();
    var optionTwo = $('#optionTwo').val();
    var optionThree = $('#optionThree').val();
    var category = $('#categoryId').val();
    //var subcategory = $('#subcategoryId').val();
    var difficulty = $('#levelOfQuestion').val();
    
    
    //alert("Question=" + question + "Answer=" + answer + "Answe1=" + optionOne + "Answer2=" + optionTwo + "Answer3=" + optionThree);
    
    if(question == "" || answer == "" || optionOne == "" || optionTwo == "" || optionThree == "" || difficulty== ""){
        alert("Please Complete the form!");
    }
    
    else{
        //alert("Success");
        $.post("_action/action_AddQuestion.php",{security:security, question:question, answer:answer, optionOne:optionOne, optionTwo:optionTwo, optionThree:optionThree, category:category, difficulty:difficulty},
                        function(data){ 
                            clearQuestionForm();
                            
                            $(".messageListener").html(data);
                            refreshQuestionList();
                        });
         return false;
    }
}   

////refresh question listing///
function refreshQuestionList(){
    var category = $('#categoryId').val();
    var subcategory = $('#subcategoryId').val();
    $.post("_action/action_RefreshQuestionList.php",{category:category, subcategory:subcategory},
                        function(data){ 
                            ///clearQuestionForm();
                            //refreshQuestionList();
                             $("#categoryList").html(data); 
                        });
         return false;
}

function refreshStudentList(){
    var searchString = "*";
     $.post("_action/action_SearchStudent.php",{searchString:searchString},
                        function(data){ 
                            $("#studentList").html(data);
                        });
      return false;
}

/////clear Form details///
function clearCategoryForm(){
    $('.categoryName').val("");
    $('.categoryDesc').val("");
}

/////clear Form details///
function clearQuestionForm(){
    $('#question').val("");
    $('#answer').val("");
    $('#optionOne').val("");
    $('#optionTwo').val("");
    $('#optionThree').val("");
}

function activateExam(){
    var temp = "";
    //alert("test");
    $("#keyActivator :checked").each(function() {
          temp = temp + "." + $(this).val();
    });
    
    $.post("_action/action_ActivateExam.php",{temp:temp},
                        function(data){ 
                            refreshStudentList();
                            $(".messageListener").html(data);
                        });
         return false;
    
}

function getListExamPerCategory(){
    //alert("Test");
     $.post("_action/action_GetListOfExam.php",{},
                        function(data){ 
                           //alert(data);
                            //refreshStudentList();
                         $("#activeExam").html(data);
                        });
      return false;
}

function startExam(target){
    var studId = $("#studentId").val();
    //alert(studId);
     $.post("_action/action_BeginExam.php",{studId:studId,target:target},
                        function(data){ 
                           //alert(data);
                            //refreshStudentList();
                         $("#activeExam").html(data);
                        });
         return false;
}

function checkAnswer(actualAnswer,category){
    currentQuestion = $("#studQuestionId").val();
    //alert(target+" "+currentQuestion );
    $("input[name='multipleChoice']").each(function(i) {
            $(this).attr('disabled', 'disabled');
     });
    //alert(target+" "+currentQuestion);
    $.post("_action/action_CheckAnswer.php",{actualAnswer:actualAnswer, currentQuestion:currentQuestion,category:category},
                        function(data){ 
                            $("#resultAnswer").html(data);
                            //refreshStudentList();
                        });
     return false;
}

function changePassword(security){
	var old = $("#oldpass").val();
	var npass = $("#newpass").val();
	var confirmpass = $("#confirmpass").val();
	
		//alert(old + npass + confirmpass);
	$.post("_action/action_ChangePassword.php",{security:security, old:old, npass:npass, confirmpass:confirmpass },
                        function(data){ 
                            //refreshStudentList();
                            $(".messageListener").html(data);
							$("#oldpass").val("");
							$("#newpass").val("");
							$("#confirmpass").val("");
                        });
         return false;
}

function startCategoryExam(target){
    var studId = $("#studentId").val();
    //alert(studId);
     $.post("_action/action_BeginExam.php",{studId:studId, target:target},
                        function(data){ 
                           //alert(data);
                            //refreshStudentList();
                         $("#activeExam").html(data);
                        });
         return false;
}

function deleteQuestion(questionId){
    
    var r=confirm("Are you sure you want delete this Question?");
        if (r==true){
            $.post("_action/action_DeleteQuestion.php",{questionId:questionId},
            
            function(data){
                refreshQuestionList()
                $(".messageListener").html(data); 
            });
            return false;
        }
        else{
            return false;
       }
}

function addUser(){
    var studentNumber = $("#studentNumber").val();
    var lastName = $("#lastName").val();
    var firstName = $("#firstName").val();
    var middleName = $("#middleName").val();
    
     $.post("_action/action_AddUser.php",{studentNumber:studentNumber, lastName:lastName, firstName:firstName, middleName:middleName},
                        function(data){ 
                            //clearQuestionForm();
                            $(".messageListener").html(data);
                            //refreshQuestionList();
                        });
         return false;
}

$(document).ready(function(){
    $("#searching").keyup(function(){
        var searchString = $("#searching").val();
        //alert(searchString);
        $.post("_action/action_SearchStudent.php",{searchString:searchString},
                        function(data){ 
                            $("#studentList").html(data);
                            //refreshStudentList();
                        });
         return false;
    });
    
    $("#startExam").click(function(){
        var studentId = $("#studentId").val();
        //alert("Generate question");
        //alert(searchString);
        $.post("_action/action_GenerateExam.php",{studentId:studentId},
                        function(data){ 
                            $("#activeExam").html(data);
                            //refreshStudentList();
                        });
         return false;
    });
    
    $("#resumeExam").click(function(){
       var studId = $("#studentId").val();
    //alert(studId);
     $.post("_action/action_GetListOfExam.php",{studId:studId},
                        function(data){ 
                           //alert(data);
                            //refreshStudentList();
                         $("#activeExam").html(data);
                        });
         return false;
    });
});