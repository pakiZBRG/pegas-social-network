function insertUser() {
    var fname = $('#first_name').val();
    var lname = $('#last_name').val();
    var uname = $('#username').val();
    var email = $('#email').val();
    var pwd = $('#pwd').val();
    var pwd_repeat = $('#pwd_repeat').val();
    var signup = 'signup';

    $.ajax({
        method: "GET",
        url: "/includes/functions/insert_user.inc.php",
        data: {
            fname,
            lname,
            uname,
            email,
            pwd,
            pwd_repeat,
            signup
        },
        success: data => {
            $('#message').html(data)
            if(data.includes('success')){
                $(".signup-form")[0].reset();
            }
        }, 
        error: (xhr, status, error) => {
            console.log(error)
        }
    })
}

function logIn() {
    var mailuid = $('#mailuid').val();
    var pwd = $('#pwd').val();
    var login = 'login';

    $.ajax({
        method: "GET",
        url: "/includes/functions/login.inc.php",
        data: {
            mailuid,
            pwd,
            login,
        },
        success: data => {
            if(data.length < 200) {
                $('#message').html(data);
            } else {
                window.location.replace('/home')
            } 
        }, 
        error: (xhr, status, error) => {
            console.log(error)
        }
    })
}

function forgotPassword() {
    var email = $('#email').val();
    var forgotPassword = 'reset-request-submit';

    $.ajax({
        method: "GET",
        url: "/includes/functions/reset-request.inc.php",
        data: {
            email,
            forgotPassword,
        },
        success: data => {
            $('#message').html(data)
        }, 
        error: (xhr, status, error) => {
            console.log(error)
        }
    })
}

function resetPassword() {
    var selector = $('#selector').val();
    var validator = $('#validator').val();
    var pwd = $('#pwd').val();
    var pwdRepeat = $('#pwd-repeat').val();
    var resetPassword = 'reset-request-submit';

    $.ajax({
        method: "GET",
        url: "/includes/functions/reset-password.inc.php",
        data: {
            selector,
            validator,
            pwd,
            pwdRepeat,
            resetPassword,
        },
        success: data => {
            $('#message').html(data)
        }, 
        error: (xhr, status, error) => {
            console.log(error)
        }
    })
}

var limit = 5;
var start = 0;
function getPosts(limit, start) {
    var userId = $('#userId').val();

    $.ajax({
        method: "GET",
        url: "/includes/functions/get_posts.inc.php",
        data: {
            userId, 
            limit,
            start
        },
        success: (data) => {
            $('#all-feeds').append(data)
        }, 
        error: (xhr, status, error) => {
            console.log(error)
        }
    })
}

$(document).ready(function(){
    $(window).scroll(function(){
        var position = $(window).scrollTop();
        var bottom = $(document).height() - $(window).height();
        
        if(position == bottom){
            start += limit;
            getPosts(limit, start);
        }
    });
})

function getPostsAfterPostCreation() {
    var userId = $('#userId').val();
    var limit = 5;
    var start = 0;

    $.ajax({
        method: "GET",
        url: "/includes/functions/get_posts.inc.php",
        data: {
            userId,
            limit,
            start
        },
        success: (data) => {
            $('#all-feeds').html(data)
        }, 
        error: (xhr, status, error) => {
            console.log(error)
        }
    })
}

function getUserPosts(userEmail, userId) {
    $.ajax({
        method: "GET",
        url: "/includes/functions/single_post.inc.php",
        data: {
            userEmail,
            userId
        },
        success: (data) => {
            $('#feeds').html(data)
        }, 
        error: (xhr, status, error) => {
            console.log(error)
        }
    })
}

function loadComments() {
    var post_id = $('#postId').val();
    var username = $("#username").val();
    
    $.ajax({
        url: "/includes/functions/comments.inc.php",
        type: "GET",
        data: {
            post_id,
            username,
        },
        success: function(data) {
            $('#comments').html(data);
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function commentNum(postId) {
    $.ajax({
        url: "/includes/functions/comment_num.inc.php",
        type: "GET",
        data: {
            postId
        },
        success: function(data) {
            $('.comNum').html(data);
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function searchUser(){
    var search = $("#search_user").val().trim();

    $.ajax({
        url: "/includes/functions/search_user.inc.php",
        type: "GET",
        data: {
            search
        },
        success: function(data) {
            $("#members").html(data)
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function deleteComment(el) {
    var comId = $(`#${el}`).val();
    var postId = $('#postId').val();
    username = $('#username').val();

    $.ajax({
        url: "/includes/functions/delete_comment.inc.php",
        type: "GET",
        data: {
            comId,
            username
        },
        success: function(data) {
            loadComments(limit, start);
            commentNum(postId);
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function likePost(el){
    userId = $('#userId').val();
    postId = el;

    $.ajax({
        url: "/includes/functions/like_post.inc.php",
        type: "GET",
        data: {
            postId,
            userId,
        },
        success: function(data) {
            $(`#like${postId}`).html(data);
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function dislikePost(el){
    userId = $('#userId').val();
    postId = el;
    console.log(postId, userId);

    $.ajax({
        url: "/includes/functions/dislike_post.inc.php",
        type: "GET",
        data: {
            postId,
            userId,
        },
        success: function(data) {
            $(`#like${postId}`).html(data);
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function updateProfile() {
    var userId = $("#userId").val();
    var firstName = $("#first_name").val();
    var lastName = $("#last_name").val();
    var userName = $("#username").val();
    var describeUser = $("#bio").val();

    $.ajax({
        url: "/includes/functions/update_profile.inc.php",
        type: "POST",
        data: {
            userId,
            firstName,
            lastName,
            userName,
            describeUser
        },
        success: function(data) {
            $("#message").html(data.split('</p>')[0]);
            $("#navName").text(data.split('</p>')[1]);
            $('#navName').attr('href', `/profile/${data.split('</p>')[1]}`)
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function follow() {
    var follower = $('#follower').val();
    var followed = $('#followed').val();

    $.ajax({
        url: "/includes/functions/follow.inc.php",
        type: "POST",
        data: {
            follower,
            followed,
        },
        success: function(data) {
            $('#follow').html(data)
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function unfollow() {
    var follower = $('#follower').val();
    var followed = $('#followed').val();

    $.ajax({
        url: "/includes/functions/unfollow.inc.php",
        type: "POST",
        data: {
            follower,
            followed,
        },
        success: function(data) {
            $('#follow').html(data)
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function editMode(el) {
    $.ajax({
        url: "/edit_post.php",
        type: "GET",
        data: {
            postId: el,
        },
        success: function(data) {
            $(`#${el}`).html(data);
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function deletePost(postId, userEmail, userId) {
    $.ajax({
        url: "/includes/functions/delete_post.inc.php",
        type: "GET",
        data: {
            postId
        },
        success: function(data) {
            getUserPosts(userEmail, userId)
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function loadMessagesAndUser(userId, loggedUser) {
    $.ajax({
        url: "/includes/functions/messages.inc.php",
        type: "GET",
        data: {
            userId,
            loggedUser
        },
        success: function(data) {
            $('#messages').html(data);
            $('.follower-table').scrollTop($('.follower-table')[0].scrollHeight);
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function sendMessage(reciever, sender) {
    var msg = $('#msg').val();

    $.ajax({
        url: "/includes/functions/send_message.inc.php",
        type: "POST",
        data: {
            reciever,
            sender,
            msg
        },
        success: function(data) {
            $('.follower-messages').append(data);
            $('#sendMsg')[0].reset();
            $('.follower-table').scrollTop($('.follower-table')[0].scrollHeight);
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function deleteUser(userId) {
    $.ajax({
        url: "/includes/functions/delete_user.inc.php",
        type: "POST",
        data: {
            userId
        },
        success: function() {
            window.location.replace('/')
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function displayTooltip(userId, postId) {
    $.ajax({
        url: "/includes/tooltip.php",
        type: "GET",
        data: {
            userId
        },
        success: function(data) {
            $(data).appendTo(`#tooltipPlace${postId}`).fadeIn(200);
        },
        error: function(e) {
            console.log(e)
        }          
    });
}

function removeTooltip(postId) {
    $(`#tooltipPlace${postId} .user-tooltip`).remove();
}

// multipart/form-data
$(document).ready(function () {
    $("#postForm").on('submit',function(e) {
        e.preventDefault();
        $.ajax({
            url: "/includes/functions/create_post.inc.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $('#message').html(data);
                $('#postForm')[0].reset();
                $('#showImg')[0].src = '';
                $('#showImg').css({'height': '0'});
                getPostsAfterPostCreation();
            },
            error: function(e) {
                console.log(e)
            }          
        });
    });

    $("#coverForm").on('change', function(){
        $.ajax({
            url: "/includes/functions/update_coverImage.inc.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                console.log(data)
                if(data.includes('assets')){
                    $('#cover').attr('src', data);
                }
            },
            error: function(e) {
                console.log(e)
            }          
        });
    });

    $("#profileForm").on('change', function(){
        $.ajax({
            url: "/includes/functions/update_profileImage.inc.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                if(data.includes('assets')){
                    $('#profile').attr('src', data);
                }
            },
            error: function(e) {
                console.log(e)
            }          
        });
    });

    $("#updatePost").on('submit',function(e) {
        e.preventDefault();
        $.ajax({
            url: "/includes/functions/update_post.inc.php",
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
                $("#message").html(data);
            },
            error: function(e) {
                console.log(e)
            }          
        });
    });

    $('#commentForm').on('submit', function(e) {
        e.preventDefault();
        var postId = $('#postId').val();
        var comment = $('#comment').val();
        var userId = $('#userId').val();
        var username = $('#username').val();

        if($.trim(comment) == ''){
            $("#message").html("<p class='msg warning'><i class='fa fa-exclamation-triangle'></i> Insert comment</p>");
        } else {
            $.ajax({
                url: "/includes/functions/create_comment.inc.php",
                type: "POST",
                data: {
                    comment,
                    userId,
                    username,
                    postId
                },
                success: function(data) {
                    loadComments(limit, start);
                    commentNum(postId);
                    $('#commentForm')[0].reset();
                },
                error: function(e) {
                    console.log(e)
                }          
            });
        }
    });
});