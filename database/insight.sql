
/**
 * Author:  hp
 * Created: 21 Nov 2018
 */

SELECT a.name, a.number,a.type, b.phone, b.name, b."schema_name", b.usertype FROM  calls a left join all_users b on  right(a.number,9)= right(b.phone,9)