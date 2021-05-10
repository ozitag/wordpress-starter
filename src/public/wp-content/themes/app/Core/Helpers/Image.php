<?php

namespace Core\Helpers;

class Image
{
    static function renderSimpleImage($attachmentId, $attachment2xId = null, string $alt = '')
    {
        if (is_array($attachmentId)) {
            if (isset($attachmentId['ID'])) {
                $attachmentId = $attachmentId['ID'];
            } else {
                throw new \Exception('Invalid Image');
            }
        }

        if (!$attachmentId) return;
        $imageType = get_post_mime_type($attachmentId);
        $original = wp_get_attachment_image_url($attachmentId, 'full');

        $originalImgHtml = '<img class="lazy" data-sizes="auto" data-original="' . $original . '" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="' . $alt . '">';
        if ($imageType == 'image/svg+xml' || $imageType == 'image/svg') {
            echo $originalImgHtml;
            return;
        }

        if (!$attachment2xId) {
            echo $originalImgHtml;
            return;
        }

        $original2x = wp_get_attachment_image_url($attachment2xId, 'full');
        if (!$original2x) {
            echo $originalImgHtml;
            return;
        }

        $output = '<picture>';
        $srcset = $original . ' 1x, ' . $original2x . ' 2x';
        $output .= '<source data-srcset="' . $srcset . '" type="' . $imageType . '">';

        $output .= $originalImgHtml;
        $output .= '</picture>';

        echo $output;
    }

    static function render($attachmentId = null, ?string $size = 'full', bool $use2x = false, string $alt = '')
    {
        if (is_array($attachmentId)) {
            if (isset($attachmentId['ID'])) {
                $attachmentId = $attachmentId['ID'];
            } else {
                throw new \Exception('Invalid Image');
            }
        }

        if (!$attachmentId) return;
        if ($size === null) $size = 'full';

        $imageType = get_post_mime_type($attachmentId);
        $original = (wp_get_attachment_image_url($attachmentId, $size));

        $originalImgHtml = '<img class="lazy" data-sizes="auto" data-original="' . $original . '" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="' . $alt . '">';
        if ($imageType == 'image/svg+xml' || $imageType == 'image/svg') {
            echo $originalImgHtml;
            return;
        }

        $output = '<picture>';

        if ($use2x) {
            $image2x = (wp_get_attachment_image_url($attachmentId, $size . '@2x'));
            $srcset = $original . ' 1x, ' . $image2x . ' 2x';
        } else {
            $image = wp_get_attachment_image_src($attachmentId, $size);
            $image_meta = wp_get_attachment_metadata($attachmentId);
            list($src, $width, $height) = $image;
            $size_array = array(absint($width), absint($height));
            $srcset = (wp_calculate_image_srcset($size_array, $src, $image_meta, $attachmentId));
        }
        $output .= '<source data-srcset="' . $srcset . '" type="' . $imageType . '">';

        $output .= $originalImgHtml;
        $output .= '</picture>';

        echo $output;
    }

    static function renderImageWithMobile($attachmentId = null, $mobileAttachmentId = null, ?string $size = null, ?string $mobileSize = null, bool $use2x = true, bool $mobileUse2x = true, string $alt = '')
    {
        if (is_array($attachmentId)) {
            if (isset($attachmentId['ID'])) {
                $attachmentId = $attachmentId['ID'];
            } else {
                throw new \Exception('Invalid Image');
            }
        }

        if (is_array($mobileAttachmentId)) {
            if (isset($mobileAttachmentId['ID'])) {
                $mobileAttachmentId = $mobileAttachmentId['ID'];
            } else {
                throw new \Exception('Invalid Image');
            }
        }

        if (!$attachmentId) return;

        if ($size === null) $size = 'full';
        if ($mobileSize === null) $mobileSize = 'full';
        if (!$mobileAttachmentId) $mobileAttachmentId = $attachmentId;

        $imageType = get_post_mime_type($attachmentId);
        $original = (wp_get_attachment_image_url($attachmentId, $size));

        $originalImgHtml = '<img class="lazy" data-sizes="auto" data-original="' . $original . '" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt="' . $alt . '">';
        if ($imageType == 'image/svg+xml' || $imageType == 'image/svg') {
            echo $originalImgHtml;
            return;
        }

        $output = '<picture>';
        $output .= "\n";

        if ($mobileAttachmentId) {
            $mobileOriginal = (wp_get_attachment_image_url($mobileAttachmentId, $mobileSize));
            if ($mobileUse2x) {
                $mobileImage2x = (wp_get_attachment_image_url($mobileAttachmentId, $mobileSize . '@2x'));
                $srcset = $mobileOriginal . ' 1x, ' . $mobileImage2x . ' 2x';
            } else {
                $mobileImage = wp_get_attachment_image_src($mobileAttachmentId, $mobileSize);
                $image_meta = wp_get_attachment_metadata($mobileAttachmentId);
                list($src, $width, $height) = $mobileImage;
                $size_array = array(absint($width), absint($height));
                $srcset = (wp_calculate_image_srcset($size_array, $src, $image_meta, $mobileAttachmentId));
            }
            $output .= '<source media="(max-width: 767px)"  data-srcset="' . $srcset . '" type="' . $imageType . '">';
        }
        $output .= "\n";


        if ($use2x) {
            $image2x = (wp_get_attachment_image_url($attachmentId, $size . '@2x'));
            $srcset = $original . ' 1x, ' . $image2x . ' 2x';
        } else {
            $image = wp_get_attachment_image_src($attachmentId, $size);
            $image_meta = wp_get_attachment_metadata($attachmentId);
            list($src, $width, $height) = $image;
            $size_array = array(absint($width), absint($height));
            $srcset = (wp_calculate_image_srcset($size_array, $src, $image_meta, $attachmentId));
        }
        $output .= '<source data-srcset="' . $srcset . '" type="' . $imageType . '">';
        $output .= "\n";

        $output .= $originalImgHtml;
        $output .= "\n";
        $output .= '</picture>';

        echo $output;
    }

    static function renderIcon(string $icon)
    {
        echo '<svg class="icon icon-' . $icon . '">
                        <use xmlns:xlink="http://www.w3.org/1999/xlink"
                             xlink:href="' . get_template_directory_uri() . '/html/dist/assets/images/spriteInline.svg#' . $icon . '"/>
                    </svg>';
    }


    static function renderHtmlImage(string $image, string $ext = 'png')
    {
        $dirPath = get_template_directory() . '/html/dist/assets/images';

        $imagePath = $dirPath . '/' . $image . '.' . $ext;
        if (!is_file($imagePath)) {
            return;
        }

        $image2xPath = $dirPath . '/' . $image . '@2x.' . $ext;
        $has2x = is_file($image2xPath);

        $imageWebpPath = $dirPath . '/' . $image . '.webp';
        $hasWebp = is_file($imageWebpPath);

        $imageUri = get_template_directory_uri() . '/html/dist/assets/images/' . $image;

        echo '<picture>';

        if ($hasWebp) {
            echo '<source data-srcset="' . $imageUri . '.webp' . ($has2x ? ', ' . $imageUri . '@2x.webp 2x' : '') . '" type="image/webp">';
        }

        $mimeType = $ext == 'png' ? 'image/png' : 'image/jpeg';
        echo '<source data-srcset="' . $imageUri . '.' . $ext . ($has2x ? ', ' . $imageUri . '@2x.' . $ext . ' 2x' : '') . '" type="' . $mimeType . '">';

        echo '<img class="lazy" data-sizes="auto" data-original="' . $imageUri . '.' . $ext . '"
                src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" alt>';

        echo '</picture>';
    }

    static function renderSvgImageAsInline(?int $attachment_id)
    {
        if (!$attachment_id) return;

        $imageType = get_post_mime_type($attachment_id);
        if ($imageType != 'image/svg+xml') {
            self::render($attachment_id);
            return;
        }

        $attachment = wp_get_attachment_metadata($attachment_id);

        $filePath = null;
        if (isset($attachment['sizes'])) {
            $filePath = get_attached_file($attachment_id);
        } else {
            $filePath = wp_upload_dir()['basedir'] . '/' . $attachment['file'];
        }

        if (!$filePath || !is_file($filePath)) {
            return;
        }

        $f = fopen($filePath, 'r+');
        $raw = fread($f, filesize($filePath));
        fclose($f);

        echo $raw;
    }
}