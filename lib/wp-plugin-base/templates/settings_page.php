<div class="wrap">
    <h2><?php echo $title; ?></h2>
    <?php if($description): ?>
    <div class="plugin-description">
        <?php echo (function_exists('Markdown') ? Markdown($description) : nl2br($description)); ?>
    </div><br/>
    <?php endif; ?>
    <form method="post" action="options.php">
        <?php settings_fields($namespace . '_options'); ?>
        <?php $options = get_option($namespace);?>
        <table class="form-table">
            <?php foreach($settings as $slug=>$setting): ?>
            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo $namespace; ?>_<?php echo $slug; ?>">
                        <?php echo $settings[$slug]['name']; ?>
                    </label>
                </th>
                <td>
                    <?php switch($settings[$slug]['type']){
                        case 'checkbox': ?>
                        <input id="<?php echo $namespace; ?>_<?php echo $slug; ?>"
                               name="<?php echo $namespace; ?>[<?php echo $slug; ?>]"
                               type="checkbox"
                               value="1" <?php checked('1', $options[$slug]); ?> />
                    <?php
                        break;
                        case 'radio':
                            //not implemented yet
                        break;
                        case 'select':
                            // not implemented yet
                        break;
                        case 'textarea': ?>
                        <textarea id="<?php echo $namespace; ?>_<?php echo $slug; ?>"
                                  name="<?php echo $namespace; ?>[<?php echo $slug; ?>]"
                                  ><?php echo $options[$slug]; ?></textarea>
                    <?php
                        break;
                        case 'text':
                        default: ?>
                        <input id="<?php echo $namespace; ?>_<?php echo $slug; ?>"
                               name="<?php echo $namespace; ?>[<?php echo $slug; ?>]"
                               type="text"
                               value="<?php echo $options[$slug]; ?>" />
                    <?php
                        break;
                    }?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <p class="submit">
            <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
        </p>
    </form>
</div>