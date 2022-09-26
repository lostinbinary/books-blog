<?php if(defined('HEADER_SECURITY') != true) die();

    $currentUrl = "//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    if(substr($currentUrl, -1)==="/")
        $currentUrl = substr($currentUrl, 0, -1);

    $page1 = $currentUrl;
    if(strpos($currentUrl,"/page")) {
        $page1 = substr($currentUrl, 0, strpos($currentUrl,"/page") );
        $currentUrl = substr($currentUrl, 0, strpos($currentUrl,"/page") );
    }

    if($data->pagination->last_page > 1): ?>
        <div class="pagination">
            <ul>
                <?php
                    if($data->pagination->page > 1 && $data->pagination->page < 3)
                        echo "<li><a href='$page1'>$messages[previous]</a></li>";
                    else if($data->pagination->page > 1)
                        echo "<li><a href='$currentUrl/page/".($data->pagination->page-1)."'>$messages[previous]</a></li>";
                    
                    $pageAdd = 1;
                    if($data->pagination->page < 4) $pageAdd += 4-$data->pagination->page;
                    for($i=$data->pagination->page-3; $i<=$data->pagination->page+$pageAdd; $i++)
                    {
                        $href = "$currentUrl/page/" . ($i==1?$page1:$i);
                        if($i==1) $href = $page1;
                        if($i > 0 && $i <= $data->pagination->last_page) {
                            echo "<li>
                                <a ".($i!=$data->pagination->page?"href='$href'":"class='active_pag'").">$i</a>
                            </li>";
                        }
                    }
                    if($data->pagination->page+1 < $data->pagination->last_page)
                        echo "...<li><a href='$currentUrl/page/{$data->pagination->last_page}'>{$data->pagination->last_page}</a></li>";
                    if($data->pagination->last_page!=$data->pagination->page)
                        echo "<li><a href='$currentUrl/page/".($data->pagination->page+1)."'>$messages[next]</a></li>";
                ?>
            </ul>
        </div>
    <?php else: ?>
        <!-- <div class="pagination"><?= $messages['no_data'] ?></div> -->
    <?php endif ?>