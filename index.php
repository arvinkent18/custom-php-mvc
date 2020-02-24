<?php
    // Turn off error reporting
    error_reporting(0);
    
    require_once('app/config/database.php');
    require_once('app/controllers/NewsController.php');
    
    $db = new Database();

    $action = '';

    if (!empty($_REQUEST['action'])) {
        $action = urlencode($_REQUEST['action']);
    }

    switch ($action) {
        case 'news-add':
            if (isset($_REQUEST['add'])) {
                $title = $_REQUEST['title'];
                $description = $_REQUEST['description'];
                $source = $_REQUEST['source'];
                $url = isset($_REQUEST['url']) ? $_REQUEST['url'] : null;
                $image = isset($_FILES['image']) ? $_FILES['image']: null;

                $news = new NewsController();
                $createNews = $news->store($title, $description, $source, $url, $image);
                

                if ($createNews == 0) {
                    $message .= 'Successfully created news';

                    header('Location: index.php?msg=' . urlencode($message));
                } elseif ($createNews == 1) {
                    $html = '<div alert=\"text-center alert alert-danger\">';
                    $html .= 'Please upload image up to 8 mb only';
                    $html .= '</div>';

                    echo $html;
                } elseif ($createNews == 2) {
                    $html = '<div alert=\"text-center alert alert-danger\">';
                    $html .= 'Please upload a valid image';
                    $html .= '</div>';

                    echo $html;
                }
                elseif ($createNews == 3) {
                    $html = '<div alert=\"text-center alert alert-danger\">';
                    $html .= 'News is already existing';
                    $html .= '</div>';

                    echo $html;
                }
                else {
                    header('Location: index.php');
                }
            }

            require_once('resources/views/news-add.php');

            break;
        
        default:
            $news = new NewsController();
            $result = $news->index();

            require_once('resources/views/news.php');
            
            break;
    }