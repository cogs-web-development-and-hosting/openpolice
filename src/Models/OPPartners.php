<?php namespace OpenPolice\Models;
// generated from /resources/views/admin/db/export-laravel-model-gen.blade.php

use Illuminate\Database\Eloquent\Model;

class OPPartners extends Model
{
	protected $table 		= 'OP_Partners';
	protected $primaryKey 	= 'PartID';
	public $timestamps 		= true;
	protected $fillable 	= 
	[	
		'PartType', 
		'PartUserID', 
		'PartPersonID', 
		'PartTitle', 
		'PartCompanyName', 
		'PartCompanyWebsite', 
	];
}