<?php
include_once 'header.php';
?>
<style>
    /*About Page Styles*/
    .about-section {
        max-width: 100%;
        margin: 40px auto;
        padding: 40px;
        text-align: center;
        background: url("img/pochacco_1.jpg") no-repeat center center;
        /* Adjust the relative path as necessary */
        background-size: cover;
        position: relative;
        z-index: 1;
    }

    .about-section::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        background: rgba(255, 255, 255, 0.8);
        /* White background with 80% opacity */
        z-index: -1;
    }

    .about-section h1,
    .about-section h2 {
        color: #333;
    }

    .about-section p {
        color: #555;
        line-height: 1.6;
    }
</style>

<section class="about-section">
    <h1>About Kids’ World of Fun</h1>
    <p>Welcome to <strong>Kids’ World of Fun</strong>, the place where learning meets excitement! Our game is not just a game; it's a journey through various challenges that stimulate your mind and tickle your funny bone.</p>

    <h2>Discover & Learn</h2>
    <p>Our game is designed with love for kids of all ages. Each level is crafted to help you learn new skills, from problem-solving to pattern recognition. As you move through the levels, you'll discover new letters and words, and even learn how to sort them like a pro.</p>

    <h2>Safe & Friendly</h2>
    <p>Safety comes first in our world. We ensure a safe virtual environment so parents can relax while their kids embark on an adventure of learning and joy.</p>

    <h2>Join the Adventure</h2>
    <p>Are you ready to step into a world filled with colorful letters and exciting challenges? Are you prepared to earn your spot on the leaderboard while making new friends? If yes, then it's time to sign up and join the fun!</p>

    <h2>Our Mission</h2>
    <p>Our mission is simple: make learning fun. With each level, you'll not only challenge your brain but also have a blast. It’s time to turn the page to a new adventure in learning. Ready, set, play!</p>

    <h2>Connect with Us</h2>
    <p>If you have any questions, suggestions, or just want to share your high score, feel free to reach out to us. We love hearing from our players!</p>

    <p><i>Team Kids’ World of Fun</i></p>
</section>

<?php
include_once 'footer.php';
?>