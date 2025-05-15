<?php

namespace App\Models\Base;

use App\Models\Base\BaseModel;

class DT extends BaseModel 
{
    const DEFAULT_D = 1;
    const DEFAULT_DT = 12;
    const DEFAULT_T = 61;
    const DEFAULT_FIRST_DAYW = 1;
//	const DEFAULT_TZ = 'UTC';
    const DEFAULT_TZ = 'Europe/Chisinau';
	
    const DATE_SQL = 1;					// 2014-12-24
    const DATE_SHORT_DMY = 2;			// 9 Feb 15
    const DATE_SHORTMONTH = 3;			// 24 Dec 2014
    const DATE_MEDIUMMONTH = 4;			// 09 Februarie 2015
    const US = 5;						// 02/09/2015
    const DATE_FULL = 6;				// Luni, 09 Februarie 2015
    const DM_SHORT = 7;					// 09.02
    const DATE_MMONTH_YEAR = 8;			// februarie 2015 - nu se arata utilizatorilor
	
    const DATE_HOUR 	= 10;			// ora: H
    const DATE_MIN 		= 11;			// ora: i
	
	const DATETIME_ROMANIAN = 12;		// 24.12.2014 14:34
	const DATE_ROMANIAN = 14;		// 24.12.2014
	
    const DATETIME_ES = 13;		// 2004-02-12T15:19:21+00:00
	
    const DATETIME_SQL = 30;			// 2014-12-24 14:34:18
    const DATETIME_SHORT = 31;			// 9 Feb 15:03
    const DATETIME_SQL_SHORT = 32;		// 2014-12-24 14:34
    const DATETIME_SQL_PM_LONG = 33;	// 2014-12-24 2:34:18 PM
    const DATETIME_SQL_PM_SHORT = 34;	// 2014-12-24 2:34 PM
	
    const DATETIME_SHORT_DMY_LONG = 35;	// 9 Feb 15 14:34:18
    const DATETIME_SHORT_DMY_SHORT = 36;// 9 Feb 15 14:34
    const DATETIME_SHORT_DMY_PM_LONG = 37;	// 9 Feb 15 2:34:18 PM
    const DATETIME_SHORT_DMY_PM_SHORT = 38;	// 9 Feb 15 2:34 PM
	
    const DATETIME_SHORTMONTH_LONG = 39;		// 09 Feb 15 14:34:18
    const DATETIME_SHORTMONTH_SHORT = 40;		// 09 Feb 15 14:34
    const DATETIME_SHORTMONTH_PM_LONG = 41;		// 09 Feb 15 2:34:18 PM
    const DATETIME_SHORTMONTH_PM_SHORT = 42;	// 09 Feb 15 2:34 PM
	
    const DATETIME_MEDIUMMONTH_LONG = 43;		// 09 Februarie 15 14:34:18
    const DATETIME_MEDIUMMONTH_SHORT = 44;		// 09 Februarie 15 14:34
    const DATETIME_MEDIUMMONTH_PM_LONG = 45;	// 09 Februarie 15 2:34:18 PM
    const DATETIME_MEDIUMMONTH_PM_SHORT = 46;	// 09 Februarie 15 2:34 PM
	
    const DATETIME_US_LONG = 47;		// 02/09/2015 14:34:18
    const DATETIME_US_SHORT = 48;		// 02/09/2015 14:34
    const DATETIME_US_PM_LONG = 49;		// 02/09/2015 2:34:18 PM
    const DATETIME_US_PM_SHORT = 50;	// 02/09/2015 2:34 PM
	
    const TIME_SQL = 60;				// 14:34:18
    const TIME_SQL_SHORT = 61;				// 14:34
    const TIME_PM_LONG = 62;				// 2:34:18 PM
    const TIME_PM_SHORT = 63;				// 2:34 PM
    
    
    // --------------------------------------------
	// returneaza ID format pentru DATATIME pentru utilizatorul curent
    public static function GDT_F()
    {
		$id = self::DEFAULT_DT;
		return (int)$id;
    }      
    
    // --------------------------------------------
	// returneaza ID format pentru DATATIME pentru utilizatorul curent
    public static function GD_F()
    {
		$id = self::DEFAULT_DT;
		return (int)$id;
    }      

    // --------------------------------------------
    protected static function idhaslabel($idf)
    {
		if (in_array($idf, array(
			2, 3, 4, 6, 8, 31
			, 35, 36, 37, 38
			, 39, 40, 41, 42
			, 43, 44, 45, 46
		))) return true;
		
		return false;
    }   
    
    // --------------------------------------------
	// returneaza formatul dupa ID
    public static function getfstr($idf)
    {
		// formats
		// y 	- an scurt	14 15 ...
		// Y 	- an lung	2014, 2015 ....
		// n	- luna dintr-o cifra	1, 2, 12 ...
		// m	- luna din 2 cifre		01, 02, 12 ...
		// j	- ziua dintr-o cifra	1, 2, 12 ...
		// d	- ziua din 2 cifre		01, 02, 12 ...
		// M	- denumirea scurta a lunii	jan, feb ...
		// F 	- denumirea lunga a lunii january, february ...
		// D	- denumirea scurta a zilei saptaminii	thu ...
		// l	- (L minuscul) denumirea lunga a zilei saptaminii	friday ...
		
		switch ($idf) 
		{
			case 1: // DATE_SQL						2015-02-09
				return 'Y-m-d';
				break;
			case 2: // DATE_SHORT_DMY				9 Feb 15
				return 'j M y';
				break;
			case 3: // DATE_SHORTMONTH				09 Feb 2015
				return 'd M Y';
				break;
			case 4: // DATE_MEDIUMMONTH				09 Februarie 2015
				return 'd F Y';
				break;
			case 5: // US							02/09/2015
				return 'm/d/Y';						
				break;
			case 6: // DATE_FULL					Luni, 09 Februarie 2015
				return 'l, d F Y';
				break;
			case 7: // DM_SHORT						09.02
				return 'd.m';
				break;
			case 8: // DATE_MMONTH_YEAR				februarie 2015
				return 'F Y';
				break;
				
			case 10: // DATE_HOUR					16
				return 'H';
				break;
			case 11: // DATE_MIN					45
				return 'i';
				break;
				break;
			case 12: // DATETIME_ROMANIAN = 12;		// 24.12.2014 14:34
				return 'd.m.Y H:i';
				break;
			case 14: // DATE_ROMANIAN = 14;		// 24.12.2014
				return 'd.m.Y';
				break;
			case 13: // DATETIME_ES = 13;		// 2004-02-12T15:19:21+00:00
				return 'c';
				break;
				
			case 30: // DATETIME_SQL				2015-02-09 14:34:45
				return 'Y-m-d H:i:s';
				break;
			case 31: // DATETIME_SHORT				9 Feb 15:03
				return 'j M H:i';
				break;
			case 32: // DATETIME_SQL_SHORT				2015-02-09 14:34
				return 'Y-m-d H:i';
				break;
			case 33: // DATETIME_SQL_PM_LONG		2015-02-09 2:34:45 PM
				return 'Y-m-d h:i:s A';
				break;
			case 34: // DATETIME_SQL_PM_SHORT		2015-02-09 2:34 PM
				return 'Y-m-d h:i A';
				break;
				
			case 35: // DATETIME_SHORT_DMY_LONG		9 Feb 15 14:34:18
				return 'j M y H:i:s';
				break;
			case 36: // DATETIME_SHORT_DMY_SHORT		9 Feb 15 14:34
				return 'j M y H:i';
				break;
			case 37: // DATETIME_SHORT_DMY_PM_LONG		9 Feb 15 2:34:18 PM
				return 'j M y h:i:s A';
				break;
			case 38: // DATETIME_SHORT_DMY_PM_LONG		9 Feb 15 2:34 PM
				return 'j M y h:i A';
				break;
				
			case 39: // DATETIME_SHORTMONTH_LONG		09 Feb 15 14:34:18
				return 'd M y H:i:s';
				break;
			case 40: // DATETIME_SHORTMONTH_SHORT		09 Feb 15 14:34
				return 'd M y H:i';
				break;
			case 41: // DATETIME_SHORTMONTH_PM_LONG		09 Feb 15 2:34:18 PM
				return 'd M y h:i:s A';
				break;
			case 42: // DATETIME_SHORTMONTH_PM_SHORT		09 Feb 15 2:34 PM
				return 'd M y h:i A';
				break;
				
			case 43: // DATETIME_MEDIUMMONTH_LONG		09 Februarie 15 14:34:18
				return 'd F y H:i:s';
				break;
			case 44: // DATETIME_MEDIUMMONTH_SHORT		09 Februarie 15 14:34
				return 'd F y H:i';
				break;
			case 45: // DATETIME_MEDIUMMONTH_PM_LONG		09 Februarie 15 2:34:18 PM
				return 'd F y h:i:s A';
				break;
			case 46: // DATETIME_MEDIUMMONTH_PM_SHORT		09 Februarie 15 2:34 PM
				return 'd F y h:i A';
				break;
				
			case 47: // DATETIME_US_LONG		02/09/2015 14:34:18
				return 'm/d/Y H:i:s';
				break;
			case 48: // DATETIME_US_SHORT		02/09/2015 14:34
				return 'm/d/Y H:i';
				break;
			case 49: // DATETIME_US_PM_LONG		02/09/2015 2:34:18 PM
				return 'm/d/Y h:i:s A';
				break;
			case 50: // DATETIME_US_PM_SHORT	02/09/2015 2:34 PM
				return 'm/d/Y h:i A';
				break;				
				
				
				
				
			case 60: // TIME_SQL					14:34:45
				return 'H:i:s';
				break;
			case 61: // TIME_SQL_SHORT					14:34
				return 'H:i';
				break;
			case 62: // TIME_PM_LONG					2:34:45 PM
				return 'h:i:s A';
				break;
			case 63: // TIME_PM_SHORT					14:34 PM
				return 'h:i A';
				break;
				
				
			default:
			   return 'Y-m-d';
		}
    } 


    // --------------------------------------------
	// returneza data in ID-ul la format trimis
    public static function FD($idf, $date = NULL)
    {
		if (is_null($date)) $date = new \DateTime();
		
		if (!self::idhaslabel($idf)) return $date->format(self::getfstr($idf));
		
		// formatul contine label-uri si se formeazaaparte
		// -----------------
		if ($idf == 2)
		{
			// DATE_SHORT DAY MONTH YEAR
			$d = '';
			$d .= $date->format('j');
			$d .= ' ';
			$d .= _GL($date->format('M'));
			$d .= ' ';
			$d .= $date->format('Y');
			return $d;
		}
		// -----------------
		if ($idf == 3)
		{
			// DATE_SHORTMONTH
			$d = '';
			$d .= $date->format('d');
			$d .= ' ';
			$d .= _GL($date->format('M'));
			$d .= ' ';
			$d .= $date->format('Y');
			return $d;
		}
		// -----------------
		if ($idf == 4)
		{
			// DATE_MEDIUMMONTH
			$d = '';
			$d .= $date->format('d');
			$d .= ' ';
			$d .= _GL($date->format('F'));
			$d .= ' ';
			$d .= $date->format('Y');
			return $d;
		}
		// -----------------
		if ($idf == 6)
		{
			// DATE_MEDIUMMONTH
			$d = '';
			$d .= $date->format('l');
			$d .= ', ';
			$d .= $date->format('d');
			$d .= ' ';
			$d .= _GL($date->format('F'));
			$d .= ' ';
			$d .= $date->format('Y');
			return $d;
		}
		// -----------------
		if ($idf == 8)
		{
			// DATE_MMONTH_YEAR
			$d = '';
			$d .= _GL($date->format('F'));
			$d .= ' ';
			$d .= $date->format('Y');
			return $d;
		}
		// -----------------
		if ($idf == 31)
		{
			// DATETIME_SHORT
			$d = '';
			$d .= $date->format('j');
			$d .= ' ';
			$d .= _GL($date->format('M'));
			$d .= ' ';
			$d .= $date->format('H:i');
			return $d;
		}
		
		
		
		
		
		
		// -----------------
		if ($idf == 35)
		{
			// DATETIME_SHORT_DMY_LONG
			$d = '';
			$d .= $date->format('j');
			$d .= ' ';
			$d .= _GL($date->format('M'));
			$d .= ' ';
			$d .= $date->format('Y H:i:s');
			return $d;
		}
		// -----------------
		if ($idf == 36)
		{
			// DATETIME_SHORT_DMY_SHORT
			$d = '';
			$d .= $date->format('j');
			$d .= ' ';
			$d .= _GL($date->format('M'));
			$d .= ' ';
			$d .= $date->format('Y H:i');
			return $d;
		}
		// -----------------
		if ($idf == 37)
		{
			// DATETIME_SHORT_DMY_PM_LONG
			$d = '';
			$d .= $date->format('j');
			$d .= ' ';
			$d .= _GL($date->format('M'));
			$d .= ' ';
			$d .= $date->format('Y h:i:s A');
			return $d;
		}
		// -----------------
		if ($idf == 38)
		{
			// DATETIME_SHORT_DMY_PM_SHORT
			$d = '';
			$d .= $date->format('j');
			$d .= ' ';
			$d .= _GL($date->format('M'));
			$d .= ' ';
			$d .= $date->format('Y h:i A');
			return $d;
		}
		// -----------------
		
		
		
		
		
		
		// -----------------
		if ($idf == 39)
		{
			// DATETIME_SHORTMONTH_LONG
			$d = '';
			$d .= $date->format('d');
			$d .= ' ';
			$d .= _GL($date->format('M'));
			$d .= ' ';
			$d .= $date->format('Y H:i:s');
			return $d;
		}
		// -----------------
		if ($idf == 40)
		{
			// DATETIME_SHORTMONTH_SHORT
			$d = '';
			$d .= $date->format('d');
			$d .= ' ';
			$d .= _GL($date->format('M'));
			$d .= ' ';
			$d .= $date->format('Y H:i');
			return $d;
		}
		// -----------------
		if ($idf == 41)
		{
			// DATETIME_SHORTMONTH_PM_LONG
			$d = '';
			$d .= $date->format('d');
			$d .= ' ';
			$d .= _GL($date->format('M'));
			$d .= ' ';
			$d .= $date->format('Y h:i:s A');
			return $d;
		}
		// -----------------
		if ($idf == 42)
		{
			// DATETIME_SHORTMONTH_PM_SHORT
			$d = '';
			$d .= $date->format('d');
			$d .= ' ';
			$d .= _GL($date->format('M'));
			$d .= ' ';
			$d .= $date->format('Y h:i A');
			return $d;
		}
		// -----------------
		
		
		
		
		
		
		// -----------------
		if ($idf == 43)
		{
			// DATETIME_MEDIUMMONTH_LONG
			$d = '';
			$d .= $date->format('d');
			$d .= ' ';
			$d .= _GL($date->format('F'));
			$d .= ' ';
			$d .= $date->format('Y H:i:s');
			return $d;
		}
		// -----------------
		if ($idf == 44)
		{
			// DATETIME_MEDIUMMONTH_SHORT
			$d = '';
			$d .= $date->format('d');
			$d .= ' ';
			$d .= _GL($date->format('F'));
			$d .= ' ';
			$d .= $date->format('Y H:i');
			return $d;
		}
		// -----------------
		if ($idf == 45)
		{
			// DATETIME_MEDIUMMONTH_PM_LONG
			$d = '';
			$d .= $date->format('d');
			$d .= ' ';
			$d .= _GL($date->format('F'));
			$d .= ' ';
			$d .= $date->format('Y h:i:s A');
			return $d;
		}
		// -----------------
		if ($idf == 46)
		{
			// DATETIME_MEDIUMMONTH_PM_SHORT
			$d = '';
			$d .= $date->format('d');
			$d .= ' ';
			$d .= _GL($date->format('F'));
			$d .= ' ';
			$d .= $date->format('Y h:i A');
			return $d;
		}
		// -----------------
		
		return $date->format(self::getfstr($idf));
    } 

    public static function GDT_T($t = NULL, $setTZ = true, $fid = false)
    {
		if (is_null($t) || $t == 0){
			return null;
		} else{
			$date = new \DateTime(date(self::getfstr(self::DATETIME_SQL), $t));
		} 
		if (!$setTZ) $date->setTimezone(new \DateTimeZone('UTC'));
		
		if (!$fid) $fid = self::GDT_F();
		return self::FD($fid, $date);
    }

    public static function toTimeStamp($str)
    {
        return strtotime($str);
    }

    
    public static function convertDT($date)
    {
        return date("Y-m-d", strtotime($date));
    }

	public static function GDT_T_FRONT($key){
        return  self::GDT_T($key,  true, DT::DATE_ROMANIAN);
    }
}