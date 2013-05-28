<?php
/**
 * Class Folder
 * Collection of method for many folder related tasks. 
 * @copyright     Copyright (c) Ananda Raj Pandey <vendornepala@gmail.com>.
 * Redistributions of files must retain the above copyright notice.
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 * @author Ananda Raj Pandey <vendornepala@gmail.com>
 * @package I.Filesystem
 * 
 */

//namespace I\Filesystem;

class Folder {
    
    /**
     *  Path for folder.
     * @var string 
     */
    public $path = Null;
    
    
    /**
     * Permission for given path.
     * @var int
     */
    public $mode = '0755';    
    
    /**
     * Get current path.
     * @return string
     */
    public function pwd($path = false) {
        if (!$path && !$this->path)
            $path =getcwd ();
        
        if(!$path)
            $path=  $this->path;
        return $path;
    }
    
    
    /**
     * Create new directory.
     * @param type $path Path to create new directory.
     * @param type $mode permission mode for directory.
     * @param type $recursive php default.
     * @return void
     */
    public function mkdir($path = false, $mode = false, $recursive = true) {
        $path=$this->pwd($path);
        if (!$mode)
            $mode = $this->mode;
        return mkdir($path, $mode, $recursive);
    }
    
    
    /**
     *  List files and folder in the directory.
     * @param type $path  path to be listed.
     * @param type $sort sort the output file. 
     * @return array  array of files and folder.
     */
    public function ls($path = false, $sort = false) {
        $files = array();
        $dirs = array();
         if (!$path && !$this->path)
            return false;
         
        $path = $this->pwd($path);
       
        $itirator = new DirectoryIterator($this->path);
        foreach ($itirator as $item):
            if ($item->isDot())
                $files[] = $item->getFilename();
            if ($item->isDir())
                $dirs[] = $item->getPathname();
        endforeach;

        if ($sort) {
            $files = sort($files);
            $dirs = sort($dirs);
        }
        return array($files, $dirs);
    }

    
    /**
     * Change the folder permission.
     * @param string $path path to change the permission.
     * @param int $mode permission to give to the path.
     * @return bool  
     */
    public function chmod($path, $mode = '0755') {
        if (!$path && !$this->path)
            return false;
        if (!$path)
            $path = $this->path;
        @chmod($path, $mode);
    }
    
    
    /**
     * Copy directory from source to destination
     * @param string $path path of source.
     * @param string $toPath path to copy.
     * @param bool $overWrite bool
     * @return boolean
     */
    public function copyDir($path, $toPath,$overWrite=false) {
        
        if (!$path && !$this->path)
            return false;
        
       $path = $this->pwd($path);
       
        $directory = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::CURRENT_AS_SELF);
	$iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);
        if(!is_dir($toPath))
            $this->mkdir($toPath,0777);
        foreach ($iterator as $item):
            $dest =$toPath . DIRECTORY_SEPARATOR . $iterator->getSubPathName();
            if ($item->isDir()&& !$item->isDot()) {
            if(!is_dir($dest) ||  !$overWrite)
                $this->mkdir ($dest, 0777);
            }
            if($item->isFile()) {
                 if(!is_file($dest) ||  !$overWrite)
                @copy($item,$dest);
            }
        endforeach;
        
    }
    
    
    /**
     * Remove / delete given path directory
     * @param type $path Path to be remvoed.
     * @param type $cleanOnly dont delete the directory only files.
     * @return boolean
     */
     public function rmdir($path = false, $cleanOnly = false) {
        $files = array();
        $dirs = array();

        if (!$path && !$this->path)
            return false;
        
       $path = $this->pwd($path);

        
        $directory = new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::CURRENT_AS_SELF);
	$iterator = new RecursiveIteratorIterator($directory, RecursiveIteratorIterator::CHILD_FIRST);
			
        foreach ($iterator as $item):
            $delete =$item->getPathname();
            if ($item->isFile())
                @unlink( $delete);

            if ($item->isDir()&& !$item->isDot()&& !$cleanOnly) 
                @rmdir($delete);
            
        endforeach;
        if(!$cleanOnly)
                @rmdir($path);
        }

    /**
     * Move directory from source to destination
     * @param string $path source to copy from.
     * @param string $toPath destination to move.
     * @param bool $overWrite overwrite destination file if set true.
     * @return void
     */
    public function moveDir($path, $toPath, $overWrite = false) {
        if (!$path && !$toPath)
            return false;
        $this->copyDir($path, $toPath, $overWrite);
        $this->rmdir($path);
        
    }

    
    /**
     * Check if given path is a directory or not.
     * @param string $path Path to check 
     * @return bool
     */
    public function isDirectory($path = false) {
        $path = $this->pwd($path);
        return is_dir($path);
    }

    
    /**
     * Check if path is writeable or not.
     * @param string $path path to check.
     * @return bool
     */
    public function isWriteable($path = false) {
        $path = $this->pwd($path);
        return is_writable($path);
    }

   
}

?>
