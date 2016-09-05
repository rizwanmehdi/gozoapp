<?php $messages = $this->message->display(); ?>
<!--
<?php if(is_array($messages)):?>
    <div id="messages">
        <?php
        // display all messages
        if (is_array($messages)):
            foreach ($messages as $type => $msgs):
                if (count($msgs > 0)):
                    foreach ($msgs as $message):
                        echo ('<span class="' . $type . '">' . $message . '</span>');
                   endforeach;
               endif;
            endforeach;
        endif;
        ?>
    </div>
<?php endif;?>-->