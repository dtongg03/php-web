$(document).ready(function(){
    $("#search").keyup(function(){
        var input_search = $(this).val();
        // alert(input);
        if(input_search != ""){
            $("#search_result").css("display","block");
            $.ajax({
                url:"../php_btl/search.php",
                method:"POST",
                data:{input_search: input_search},

                success:function(data){
                     $("#search_result").html(data);
                }
            });
        }else{
            $("#search_result").css("display","none");
        }
    });
});