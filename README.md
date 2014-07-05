Codeigniter, PHP tips & tricks for developer
=========

This is a list of tips trick &  guide for these people want to learn codeigntier, php and web development
1. [Codeigniter Input for handle PUT & DELETE][1]


Codeigniter JOIN:

```php
$this->db->select('*');
$this->db->from('TableA AS A');// I use aliasing make joins easier
$this->db->join('TableC AS C', 'A.ID = C.TableAId', 'INNER');
$this->db->join('TableB AS B', 'B.ID = C.TableBId', 'INNER');
$result = $this->db->get();
```
=========


[![Donate](https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=phplaw%40gmail%2ecom&lc=VN&item_name=PHP%20CI%20Tips%20Tricks&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted)
[1]:https://gist.github.com/phplaw/6305193
