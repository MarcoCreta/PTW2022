var session_username = null
var session_id_profile = null

$(document).ready(function(){

   $(document).on('submit', ".comment-form", function(event){
      event.preventDefault();

      post = $(this).closest(".post")

      if(post.find(".comment-text").val() < 1){
         return;
      }
      comment = {
         post_ID_profile : post.find(".post-profile").html(), 
         post_username : post.find(".post-username").html(),
         content : post.find(".comment-text").val(),
         post_date : post.find(".post-date").html(),
         post_time : post.find(".post-time").html(),
      }
      create_comment(comment, post)
   });

   $(document).on("click", ".comment-number", function(event){
      if($(this).html() < 1){
         return;
      }

      post_element = $(this).closest(".post")

      post = {
         ID_profile : post_element.find(".post-profile").html(), 
         username : post_element.find(".post-username").html(),
         date : post_element.find(".post-date").html(),
         time : post_element.find(".post-time").html(),
      }
      get_comments(post, post_element)
   });


   $(document).on("submit", "#post-form", function(event){
      event.preventDefault();

      post = {
         ID_profile : $(".profile-id").attr('id'), 
         content : $("#post-text").val(),
         n_comments : 0
      }
      
      create_post(post)
   });

   $(document).on("click", ".delete-comment", function(event){
      event.preventDefault();

      post_element = $(this).closest(".post")
      comment_element = $(this).closest(".comment")
      
      comment = {
         post_ID_profile : post_element.find(".post-profile").html(), 
         post_username : post_element.find(".post-username").html(),
         post_date : post_element.find(".post-date").html(),
         post_time : post_element.find(".post-time").html(),
         date : comment_element.find(".comment-date").html(),
         time : comment_element.find(".comment-time").html(),
      }

      delete_comment(comment, comment_element)
   });

   $(document).on("click", ".delete-post", function(event){
      event.preventDefault();

      post_element = $(this).closest(".post")
      
      post = {
         ID_profile : post_element.find(".post-profile").html(),
         date : post_element.find(".post-date").html(),
         time : post_element.find(".post-time").html(),
      }

      delete_post(post, post_element)
   });
      
});

function create_post(post){
   $.ajax({
      url: "php/api-content.php",
      method: 'POST',
      data: {action:"createPost",post:post},
  }).done(function(data){
      $(".post-model").after(data)
      $("#post-text").val("")
  }).fail(

  );
}

function create_comment(comment, post_element){
   $.ajax({
      url: "php/api-content.php",
      method: 'POST',
      data: {action:"createComment",comment:comment},
  }).done(function(data){
      post_element.find(".post-comments").append(data)
      post_element.find(".comment-text").val("")
  }).fail(

  );
}

function get_comments(post, post_element){
   $.ajax({
      url: "php/api-content.php",
      method: 'GET',
      data: {action:"getComments",post:post},
  }).done(function(data){
     post_element.find(".post-comments").html(data)
  });
}

function delete_post(post, post_element){
   $.ajax({
      url: "php/api-content.php",
      method: 'POST',
      data: {action:"deletePost",post:post},
  }).done(function(data){
     response = JSON.parse(data)
     if(response["result"]){
      post_element.slideToggle("slow", function(){
         post_element.remove()
       });
     }
     console.log(response)
  }).fail(

  );
}

function delete_comment(comment, comment_element){
   $.ajax({
      url: "php/api-content.php",
      method: 'POST',
      data: {action:"deleteComment",comment:comment},
  }).done(function(data){
     response = JSON.parse(data)
     if(response["result"]){
      comment_element.slideToggle("slow", function(){
         comment_element.remove()
       });
        
     }
  }).fail(

  );
}