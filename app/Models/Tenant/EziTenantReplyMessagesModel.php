<?php

namespace App\Models\Tenant;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EziTenantReplyMessagesModel extends Model
{
    use HasFactory;

    protected $table = 'tenant_message_reply_tbl';

    static public function getAllRepliedMessages(int $user_id, ?int $is_opened, ?int $is_delete, ?int $is_replied)
    {
        $mySql =  self::select(
            'tenant_message_reply_tbl.*', 
            'users.f_name AS f_name',
            'users.l_name AS l_name',
            'users.phone AS phone',
            'users.email AS email',
            'users.user_type AS user_type',
            'users.id AS user_id',
            'users.user_img AS user_img',
        )
            ->join('users', 'users.id', '=', 'tenant_message_reply_tbl.receipient_id')
            ->where('tenant_message_reply_tbl.user_id', $user_id);


            if (isset($is_opened)) {
             
                $mySql = $mySql->where('tenant_message_reply_tbl.is_opened', $is_opened);
    
            }

            if (isset($is_delete)) {
             
                $mySql = $mySql->where('tenant_message_reply_tbl.is_deleted', $is_delete);
    
            }

            if (isset($is_replied)) {
             
                $mySql = $mySql->where('tenant_message_reply_tbl.is_replied', $is_replied);
    
            }


            
            
        $mySql = $mySql->orderBy('tenant_message_reply_tbl.created_at', 'desc')
        ->get();


        return $mySql;

    }


    
    static public function getSingleMessage(int $id)
    {
        $mySql =  self::select(
            'tenant_message_reply_tbl.*', 
            'users.f_name AS f_name',
            'users.l_name AS l_name',
            'users.email AS email',
            'users.phone AS phone',
            'users.user_type AS user_type',
            'users.id AS user_id',
            'users.user_img AS user_img',
        )
            ->join('users', 'users.id', '=', 'tenant_message_reply_tbl.user_id')
            ->where('tenant_message_reply_tbl.id', $id)
            ->first();

        return $mySql;

    }



        
    static public function getSingle($id) {

        return self::find($id);

    }

    
        
    static public function checkIfExist($name) {

 
        $mySql =  self::select(
            'tenant_message_reply_tbl.*',
        )
            ->where('tenant_message_reply_tbl.name', $name)
            // ->where('tenant_message_reply_tbl.code_name', '=', $code_name)
            ->doesntExist();

        return $mySql;

    }

    
    public function getUserImage()
    {

        if (!empty($this->user_img) && file_exists('public/uploads/users/' . $this->user_img)) {

            return url('public/uploads/users/' . $this->user_img);
        } else {
            return url('public/uploads/users/user.jpg');
        }
    }


}
