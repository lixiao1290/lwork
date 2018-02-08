<?php namespace Syscover\EmailReader;

/**
 * This library is a wrapper around the Imap library functions included in php.
 *
 * @package EmailReader
 */
final class MIME
{
    /**
     * @param string $text
     * @param string $targetCharset
     *
     * @return string
     */
    public static function decode($text, $targetCharset = 'utf-8')
    {
        if (null === $text) {
            return null;
        }

        $result = '';

        foreach (imap_mime_header_decode($text) as $word) {
            $ch = 'default' === $word->charset ? 'ascii' : $word->charset;

            if (strtoupper($ch) != strtoupper($targetCharset))
            {
                if(mb_detect_encoding($word->text) != $targetCharset)
                    $result .= iconv($ch, $targetCharset, $word->text);
                else
                    $result = $word->text;
            }
        }

        return $result;
    }
}
