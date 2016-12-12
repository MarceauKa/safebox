<?php

namespace App\Libraries;

class Browsershot extends \Spatie\Browsershot\Browsershot
{
    /**
     * Take the screenshot.
     *
     * @param $targetFile
     */
    protected function takeScreenShot($targetFile)
    {
        $tempJsFileHandle = tmpfile();

        fwrite($tempJsFileHandle, $this->getPhantomJsScript($targetFile));
        $tempFileName = stream_get_meta_data($tempJsFileHandle)['uri'];
        $cmd = escapeshellcmd("{$this->binPath} --ssl-protocol=any --ignore-ssl-errors=true ".$tempFileName);

        shell_exec($cmd);

        fclose($tempJsFileHandle);
    }
}
