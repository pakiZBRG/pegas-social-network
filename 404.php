<?php require '/includes/header.php'; ?>
<?php require '/includes/nav.php'; ?>

<main class='not-found'>
    <div class='not-found__center'>
        <h2 style='font-family: "Fredericka The Great";' class='mb-4 font-weight-bold'>404: Page Not Found</h2>
        <p>Page which you requested <span><?php echo explode("pegas", $_SERVER["REQUEST_URI"])[1]; ?></span> is not found.</p>
    </div>
</main>

<?php require '/includes/footer.php'; ?>