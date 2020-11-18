<?php


class PostView {


    protected $mainCategory;
    protected $categories;
    protected $title;
    protected $author;
    protected $postFile;
    //For the paths we have to take into account that the post files will be stored under the folders blog/posts
    const POSTS_REL_PATH = '../blog/posts';
    const POST_HEADER_PATH = '../../Private/templates/postHeader.php';
    const POST_FOOTER_PATH = '../../Private/templates/footer.php';
    const RELATED_POSTS_PATH = '../../Private/templates/relatedPosts.php';
    const NUM_RELATED_POSTS = 3;
    /**
     * Creates a file. The file will have the same name as the title but replacing spaces for dashes( - )
     */

    public static function printTitle($title,$mainImageUrl)
    {

        echo '<main>
        <div class="single-post active">
            <div class="poster-post" style="background-image:url('.$mainImageUrl.');">
            </div>
            <div class="post-content max-width">
                <h1 class="post-title">' . $title . '</h1>';
    }

    public static function printCategories($mainCategory,$categories)
    {
        $html =  '<ul class="categories-tags">
        <li class="main-category-tag">' . $mainCategory . '</li>';
        foreach ($categories as $category) {
            $html .= '<li>' . $category . '</li>';
        }
        $html .= '</ul>
        </div>';
        echo $html;
    }

    public static function printAuthor($firstName,$lastName,$profileImageUrl,$publishingDate)
    {
        echo ' <div class="post-info">
        <div class="author-info">
            <a href="../../about/"><img class="author-photo" src="' . $profileImageUrl . '" alt="profile photo"></a>
            <div>
                <h4><span class="author-name">' . $firstName . " " . $lastName . '</span></h4>
                <h5 class="email">' . $publishingDate . '</h5>
            </div>
        </div>';
    }


    public static function printText($text)
    {
        //when introducing text in different lines the editor add div containers that we have to remove
        $text = self::removeDivs($text);
        echo '<p class="text-content">' . $text .'<p>';
    }
    public static function printSubtitle($text)
    {
        echo '<h2 class="subtitle">' . $text . '</h2>';
    }
    public static function printCode($language,$text){
        $text = str_replace('</div>','',$text);
        $text = str_replace('<div>',"\r\n",$text);
        echo '<pre tabindex="0" contenteditable="true" class="'.$language.' code-wrapper"><code >'
        .$text . '</code></pre>';
    }
    public static function printContents($contents)
    {
        foreach($contents as $content){
            //$content['content'] = $this->removeDivs($content['content']);
            switch ($content['type']) {
                case 'text':
                    self::printText($content['content']);
                    break;
                case 'subtitle':
                    self::printSubtitle($content['content']);
                    break;
                case 'code':
                    self::printCode($content['options'],$content['content']);
                default:
                    break;
            }
        }

    }
    private static function removeDivs($text){
        $text = str_replace('</div>','',$text);
        $text = str_replace('<div>','<br>',$text);
        return $text;
    }
    public function printRelated(){
        //get 3 posts related with the main topic or secondary amd if not any topic
        $related = Post::getPostsByCategory($this->mainCategory,PostGenerator::NUM_RELATED_POSTS,0,$this->title);
        $numFound = count($related);
        if($numFound<PostGenerator::NUM_RELATED_POSTS){
            $moreRelated = POST::getPosts(PostGenerator::NUM_RELATED_POSTS-$numFound,0,$this->title);
        $related = array_merge($related,$moreRelated);
        }
        $html = '        <div class="max-width center ">
        <h2 class="related-title"> Related</h2>
        <ul class="related-posts-wrapper">';

        foreach($related as $post){
            $authorInfo = Post::getAuthorInfo($post['authorId']);
            //in case it does not exist we do not want to show a warning that is why we put a @
            $file = $authorInfo['profileImage'];
            $file_headers = @get_headers($file);
            if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                $exists = false;
                $authorInfo['profileImage'] = "https://i.imgur.com/wIHZKq1.png";
            }
            else {
                $exists = true;
            }

            $file = $post['mainImage'];
            $file_headers = @get_headers($file);
            if(!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
                $exists = false;
                $post['mainImage'] = "https://i.imgur.com/YcjzYu0.jpg";
            }
            else {
                $exists = true;
            }

            $mainCategory = Post::getCategoryName($post['mainCategory']);
            $url = "?id=". str_replace(' ','-',$post['title']);
            $html .='  <li>
            <a href = "'.$url.'"><img src="'.$post['mainImage'].'"></a>
            <div class="main-category">'.$mainCategory.'</div>
            <div class="related-post-info">
                <a href = "'.$url.'" ><h4 class="title">'.$post['title'].'</h4><a>
                <h5 class="email">'.$post['publishingDate'].'</h5>


                <div class="author-info">
                    <div class="author-info-align">
                        <a href="../../about/"><img class="author-photo" src="'.$authorInfo['profileImage'].'" alt="profile photo"></a>
                        <h4><span class="author-name">'.$authorInfo['firstName']." ".$authorInfo['lastName1'].'</span></h4>
                    </div>

                </div>

            </div>
        </li>';
        }

        $html .= '</ul>
                </div>';
        echo $html;
    }
    public static function closeMain()
    {
        echo '</div>';
        //require '../../Private/templates/subscription.php';
        echo '</main>';
    }
}