<?php namespace F2re\Pagecsv\Models;

use Model;
use F2re\Pagecsv\Models\Pages;

/**
 * File attachment model
 *
 * @package october\system
 * @author F2re
 */
class CSVProcess
{

    public static function process($path='')
    {
        $data_to_db = self::csv_to_array($path);
        
        $result = ['deleted'=>0, 'updated'=>0,'added'=>0];
        
        foreach ( $data_to_db as $item ){
        	if ( !is_array($item) || count($item)<7 || $item[7]=='' ){
        		continue;
        	}
        	// sluggable string
        	$item[7] = str_slug($item[7], "-");
        	$pagemodel = Pages::where('slug',$item[7])->first();
        	
        	// if page exist - try to update or delete
        	if ( $pagemodel ){
        		if ( $item[6]=='delete' ){
        			$pagemodel->delete();
        			// increment deleted files
        			$result['deleted']+=1;
        		}else
        		if ( $item[6]=='update' ){
        			$pagemodel->title = $item[0];
	        		$pagemodel->metadescr = $item[1];
	        		$pagemodel->h1 = $item[2];
	        		$pagemodel->content = $item[3];
	        		$pagemodel->category = $item[4];
	        		$pagemodel->customcontent = $item[5];
	        		$pagemodel->option = $item[6];
	        		$pagemodel->save();
	        		// incremenet updated files
	        		$result['updated']+=1;
        		}
        	}
        	// else create new page
        	else{
        		$pagemodel = new Pages;
        		$pagemodel->slug = $item[7];
        		$pagemodel->title = $item[0];
        		$pagemodel->metadescr = $item[1];
        		$pagemodel->h1 = $item[2];
        		$pagemodel->content = $item[3];
        		$pagemodel->category = $item[4];
        		$pagemodel->customcontent = $item[5];
        		$pagemodel->option = $item[6];
        		
        		if ( $pagemodel->option!='delete' ){
        			$pagemodel->save();
        			$result['added']+=1;
        		}
        	}
        	
        }
        
        return $result;
    }
    
    public static function csv_to_array($filename='', $delimiter=',')
	{
		ini_set("auto_detect_line_endings", true);
	    if(!file_exists($filename) || !is_readable($filename))
	        return FALSE;
	
	    $header = NULL;
	    $data = array();
	    if (($handle = fopen($filename, 'r')) !== FALSE)
	    {
	        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
	        {
	            if(!$header){
	                $header = $row;
	            }
	            else if ( is_array($row)&&isset($row[7])&&$row[7]!=''){
	                $data[] = $row;
	            }
	        }
	        fclose($handle);
	    }
	    return $data;
	}

}