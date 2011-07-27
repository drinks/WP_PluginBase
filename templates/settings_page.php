<div class="wrap">
    <h2><?php echo $settings_page_title; ?></h2>
    <?php if($description): ?>
    <div class="sunlight-description">
        <?php echo (function_exists('Markdown') ? Markdown($description) : nl2br($description)); ?>
    </div><br/>
    <?php endif; ?>
    <form method="post" action="options.php">
        <?php settings_fields($settings_namespace . '_options'); ?>
        <?php $options = get_option($settings_namespace);?>
        <table class="form-table">
            <?php foreach($plugin_settings as $setting): ?>
            <tr valign="top">
                <th scope="row">
                    <label for="<?php echo $settings_namespace; ?>_<?php echo $setting['slug']; ?>">
                        <?php echo $setting['name']; ?>
                    </label>
                </th>
                <td>
                    <?php switch($setting['type']){
                        case 'checkbox': ?>
                        <input id="<?php echo $settings_namespace; ?>_<?php echo $setting['slug']; ?>"
                               name="<?php echo $settings_namespace; ?>[<?php echo $setting['slug']; ?>]"
                               type="checkbox"
                               value="1" <?php checked('1', $options[$setting['slug']]); ?> />
                    <?php
                        break;
                        case 'radio':
                            //not implemented yet
                        break;
                        case 'select':
                            // not implemented yet
                        break;
                        case 'textarea': ?>
                        <textarea id="<?php echo $settings_namespace; ?>_<?php echo $setting['slug']; ?>"
                                  name="<?php echo $settings_namespace; ?>[<?php echo $setting['slug']; ?>]"
                                  ><?php echo $options[$setting['slug']]; ?></textarea>
                    <?php
                        break;
                        case 'text':
                        default: ?>
                        <input id="<?php echo $settings_namespace; ?>_<?php echo $setting['slug']; ?>"
                               name="<?php echo $settings_namespace; ?>[<?php echo $setting['slug']; ?>]"
                               type="text"
                               value="<?php echo $options[$setting['slug']]; ?>" />
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