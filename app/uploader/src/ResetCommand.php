<?php

namespace Hazzard\Filepicker;

use Intervention\Image\Commands\AbstractCommand;
use Intervention\Image\Exception\RuntimeException;

class ResetCommand extends AbstractCommand
{
    /**
     * Resets given image to its backup state
     *
     * @param  \Intervention\Image\Image $image
     * @return boolean
     */
    public function execute($image)
    {
        $backupName = $this->argument(0)->value();
        $backup = $image->getBackup($backupName);

        if (is_resource($backup) || $backup instanceof \GDImage) {
            imagedestroy($image->getCore());

            $backup = $image->getDriver()->cloneCore($backup);

            $image->setCore($backup);

            return true;
        }

        throw new RuntimeException("Backup not available. Call backup() before reset().");
    }
}
