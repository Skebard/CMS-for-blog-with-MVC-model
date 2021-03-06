<?php
/**
 * This template is meant to be use in the pages: blog, about, contact, home and blog/title-of-the-post
 */
    $current_file_name = basename($_SERVER['PHP_SELF']);
    $current_dir = basename(getcwd());
    
    session_start();

    require_once __DIR__.'/../../utils.php';
    

?>
<!DOCTYPE html>
<html lang=en>

<head>
    <title>Antonio Jorda <?php echo $current_dir === 'blog'? 'Blog': ($current_dir ==='about'? 'About': ($current_dir ==='contact'?'Contact': '')); ?></title>

    
    <!-- JQUERY -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>

    <link rel="stylesheet" href="<?php echo getResourceUrl(__DIR__,'../../../client/css/main.css'); ?>">
    <link rel="stylesheet" href="<?php echo getResourceUrl(__DIR__,'../../../client/css/loading.css'); ?>">
    
    <script defer src='<?php echo getResourceUrl(__DIR__,'../../../client/controller/header.js'); ?>'></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- google Fonts roboto-->
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
        <!-- Font Awesome icons-->
        <script src="https://kit.fontawesome.com/9547750bbd.js" crossorigin="anonymous"></script>

        <?php
    //Set scripts and styles depending on the page
    if($current_file_name ==='blog.php'){
        //echo '<link rel="stylesheet" href="../Public/css/subscription.css">';
        echo '<link rel="stylesheet" href="client/css/blog.css">';
        echo '<script defer type="module" src="client/controller/blog/main.js"></script>';
        //echo '<script defer src="../public/js/subscribe/subscribe.js"></script>';

    }else if($current_file_name === 'post.php'){
        echo '<link rel="stylesheet" href="../client/css/post.css">';
        echo ' <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.2.1/styles/atom-one-dark.min.css" integrity="sha512-Fcqyubi5qOvl+yCwSJ+r7lli+CO1eHXMaugsZrnxuU4DVpLYWXTVoHy55+mCb4VZpMgy7PBhV7IiymC0yu9tkQ==" crossorigin="anonymous" /> ';
        echo '<script defer src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.2.1/highlight.min.js" integrity="sha512-Ypjm0o7jOxAd4hpdoppSEN0TQOC19UtPAqD+4s5AlXmUvbmmS/YMxYqAqarQYyxTnB6/rqip9qcxlNB/3U9Wdg==" crossorigin="anonymous"></script>';
    
    }else if($current_dir === 'contact'){

    }else{
        //unknown
    }
    
    ?>
    </head>

<body >
    <header>
        <nav class="navigation-bar">
            <i id="btn-menu" class="fa fa-bars"></i>
            <div id='modal-nav-menu-id' class='modal-nav-menu hidden'>
                <i id="btn-close-modal-menu" class="fas fa-times"></i>
                <ul id="nav-menu-id" class='select-section'>
                    <li  <?php echo $current_file_name==='blog.php'?'class="active"':''; ?>>
                        <a href= <?php echo $current_file_name==='blog.php'?'#':'../blog.php';?>>Blog</a>
                    </li>
                    <li  <?php echo $current_file_name==='about.php'?'class="active"':''; ?>>
                    <a href='#'>About</a>
                    </li>
                    <li <?php echo $current_file_name==='contact.php'?'class="active"':''; ?>>
                    <a  href='#'>Contact</a>
                    </li>
                </ul>
            </div>

        </nav>
    </header>
    <?php
