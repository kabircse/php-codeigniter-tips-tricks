<?php
$this->db->last_query();
$this->db->insert_string();
$this->db->update_string();
$this->CI->db->queries;
#MySQL statement in the query
$this -> db -> set('created_date', 'NOW()', FALSE);
$this->db->set('received_qty', 'received_qty + 1', FALSE);

$this -> db -> insert($this -> tables['some_table'], $data);

 $this->db->where('policy_id', $policy_id);
        $this->db->where('due > ', 0);

        $this->db->limit(1);
        $this->db->orderby('date', 'DESC');
        $qry = $this->db->get($this->_tablename);
        if($qry && $qry->num_rows()>0)
            return $qry->row();
//get one row in query
$query = $this->db->get();
$ret = $query->row();
return $ret->campaign_id;

// Query stuff ...
$query = $this->db->get();

if ($query->num_rows() > 0)
{
    $row = $query->row(); 
    return $row->campaign_id;
}

return null; // or whatever value you want to return for no rows found

// JOIN TABLE IN CI
$CI->db->select('*');
                $CI->db->from('purchase');
                $CI->db->join('purchase_product', 'purchase_product.purchase_id = purchase.purchase_id');

                
                $CI->db->where('purchase.purchaser_id', $session['purchaser_id']);
// SUM IN TABLE
$this->ci->db->select_sum('oustanding');

$this->db->join('TOPICS t', 'u.user_id on t.user_id')
         ->join('QUOTES q', 't.topic_id on q.topic_id')
         ->where('u.user_id', $userId)
         ->get('USERS u');

// I always echo my queries when developing to make sure they are what i'm expecting
echo $this->db->last_query();

// SUB QUERY
$this->db->select('*')->from('school');
$this->db->where('`id` NOT IN (SELECT `id` FROM `vehicle`)', NULL, FALSE);

//UNION two queries in one query
$query = $this->db->query($query1." UNION ".$query2);
 return $query->result();

// active record left & right join in codeigniter
$this->db->join('users', 'places.place_id = user.place_id', 'left');
$this->db->join('users', 'places.place_id = user.place_id', 'right');
$this->db->join('users', 'places.place_id = user.place_id', 'inner');
$this->db->join('members', "members.id = $user_id", 'left outer');

// RETRIVE DATA IN CODEIGNITER
//-----------------------------------------------------------------------------+
return $query->result_array();
$query->result_object();
$this->db->limit(1)->where('field_name', 'field_value')->get('table_name')->row();
//-----------------------------------------------------------------------------+

// COUNT DATA IN TABLE 
$this->db->count_all_results();

//Permits you to determine the number of rows in a particular Active Record query. 
//Queries will accept Active Record restrictors such as where(), or_where(), like(), or_like(), etc. Example:
echo $this->db->count_all_results('my_table');
// Produces an integer, like 25

$this->db->like('title', 'match');
$this->db->from('my_table');
echo $this->db->count_all_results();
// see more here http://ellislab.com/codeigniter/user-guide/database/active_record.html
// Produces an integer, like 17 
//-----------------------------------------------------------------------------+

// INSERT RECORD IN CI
$data = array(
   array(
      'title' => 'My title' ,
      'name' => 'My Name' ,
      'date' => 'My date'
   ),
   array(
      'title' => 'Another title' ,
      'name' => 'Another Name' ,
      'date' => 'Another date'
   )
);

$this->db->insert_batch('mytable', $data);
// Produces: INSERT INTO mytable (title, name, date) VALUES ('My title', 'My name', 'My date'), ('Another title', 'Another name', 'Another date')

// INSERT USING SET STATEMENT
$this->db->set('name', $name);
$this->db->insert('mytable');

// Produces: INSERT INTO mytable (name) VALUES ('{$name}')
$this->db->set('field', 'field+1', FALSE);
$this->db->insert('mytable');
// gives INSERT INTO mytable (field) VALUES (field+1)

//INSERT USING A OBJECT
/*
    class Myclass {
        var $title = 'My Title';
        var $content = 'My Content';
        var $date = 'My Date';
    }
*/

$object = new Myclass;

$this->db->set($object);
$this->db->insert('mytable'); 

// UPDATE USING OBJECT

/*
    class Myclass {
        var $title = 'My Title';
        var $content = 'My Content';
        var $date = 'My Date';
    }
*/

$object = new Myclass;

$this->db->where('id', $id)->limit(1)->update('mytable', $object);

// UPDATE WITHOUT WHERE
$this->db->update('mytable', $data, "id = 4");
// MULTIPAL WHERE WITH ARRAY
$this->db->update('mytable', $data, array('id' => $id));

// DELETE DATA WITHOUT WHERE
$this->db->delete('mytable', array('id' => $id));
//TRUNCATE TABLE
$this->db->from('mytable');
$this->db->truncate();


//codeigniter db transaction
$this->db->trans_begin();

$this->db->query('AN SQL QUERY...');
$this->db->query('ANOTHER QUERY...');
$this->db->query('AND YET ANOTHER QUERY...');

if ($this->db->trans_status() === FALSE)
{
    $this->db->trans_rollback();
}
else
{
    $this->db->trans_commit();
}

//http://ellislab.com/codeigniter/user-guide/database/transactions.html
