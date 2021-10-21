<div class='deleteUser'>
    <div class="deleteUser-popup">
        <div class='deleteUser-header'>
            <h5>Are you sure you want to delete account?</h5>
        </div>
        <div class='deleteUser-content'>
            <p>You will delete all posts, messages and comments and it is irreversable action.</p>
            <button onclick="deleteUser(<?php echo $user_id ?>)">Delete</button>
            <button style="background: transparent; color: crimson" class='cancel'>Cancel</button>
        </div>
    </div>
</div>