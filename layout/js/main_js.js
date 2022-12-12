
// set menu list fixed height dynamically
var wheight = $(window).outerHeight() ,
header_height = $(".navbar").innerHeight() ; 
$(".menu").height( wheight - header_height )  ; 
$(".data").height( wheight - header_height )  ; 



function re_size_page(){
    // Justify Slider Height
    var wheight = $(window).outerHeight() ,
        header_height = $(".navbar").innerHeight() ; 
    $(".menu").height( wheight - header_height ) ; 
    $(".data").height( wheight - header_height )  ; 
    console.log(header_height) ; 
}

// show/hide category items
$(".category-dropdown-icon").each(function(){
    $(this).on("click", function(){
        
        $(this).toggleClass("fa-rotate-90") ; 
        let target = $(this).data("target") ; 
        $("#"+target).slideToggle("fast") ; 
    });
});

// open reset_password_modal when clicking the change_password_button
$("#change_password_button").on('click', function(){
    $("#reset_password_modal").modal('show') ; 
})

// submit the modal 
$(document).on("submit", "#reset_password_modal", function(event){
    event.preventDefault() ; 
    var old_password = $("#old_password").val() ; 
    var new_password = $("#new_password").val() ;
    if(old_password != '' && new_password != ''){
        // what id the old == new 
        if(old_password==new_password){
            $("#response_form").html('<div class="alert alert-danger">can not use the old one as the new password</div>') ; 
        }else{
            $.ajax({
                url:"../inc/handle_files/reset_password.php",
                method:"POST",
                data:{old_password:old_password, new_password:new_password},
                beforeSend:function(){
                    $("#reset_button").html('wait..');
                    $("#reset_button").attr('disabled', 'disabled');
                },
                success:function(data){
                    var json = JSON.parse(data) ; 
                    if(json.status == 'true'){
                        // successfully change password
                        $("#response").html('<div class="alert alert-success">password succefully changed</div>') ;
                        $("#old_password").val('') ; 
                        $("#new_password").val('') ; 
                        $("#reset_password_modal").modal('hide') ; 
                    }else{
                        // the old one is diffrent
                        $("#response_form").html('<div class="alert alert-danger">'+ json.error +'</div>') ; 
                    }
                    $("#reset_button").attr('disabled', false);
                    $("#reset_button").html('Reset');
                }
            });
        }
    }else{
        $("#response_form").html('<div class="alert alert-danger">fill all record</div>') ; 
    }
    setTimeout(function(){
        $("#response_form").html('');
        $("#response").html('');
    }, 2000);

});
