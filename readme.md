Admin Panel is  a platform to manage shulesoft operations


-------------------------------------------------------------------------------

MODELS OPERATIONS

-------------------------------------------------------------------------------


Packages Used
krlove/eloquent-model-generator

php artisan krlove:generate:model User --table-name=user

#Limitations: Does not create relationships 
--------------------------------------------------------------------------------

git old commit url
https://shulesoft@bitbucket.org/shulesoft/shulesoft.git

#administration tasks under linux
Sync files btn servers
 rsync -azvr /home/schema_backups/* root@75.119.138.7:/home/sbackup/

#update duplicates
UPDATE t SET phoneid=userid FROM (SELECT count(*),phoneid FROM t GROUP BY phoneid HAVING count(*)>1) AS foo WHERE t.phoneid=foo.phoneid;

ALTER USER postgres PASSWORD 'myPassword';
ALTER ROLE

#limit idle connections in postgres
SET SESSION idle_in_transaction_session_timeout = '3s';

#delete ALL duplicate data differ by date
WITH cte AS (
  SELECT student_id, installment_id,
         ROW_NUMBER() OVER (PARTITION BY student_id, installment_id ORDER BY created_at DESC) AS rn
  FROM shulesoft.tmembers
)
DELETE FROM shulesoft.tmembers
WHERE (student_id, installment_id) IN (
  SELECT student_id, installment_id
  FROM cte
  WHERE rn > 1
);


#DELETE all duplicate data keep one
WITH cte AS (
  SELECT student_id, uuid, min("markID"),
         ROW_NUMBER() OVER (PARTITION BY student_id, uuid ORDER BY "markID" DESC) AS rn
  FROM shulesoft.mark where schema_name='motherofmercy' group by student_id,uuid,"markID"
)
delete FROM shulesoft.mark
WHERE "markID" IN (
  SELECT min
  FROM cte
  WHERE rn >1
);

--Alternatively
delete FROM shulesoft.payments
WHERE schema_name='annagamazo' and id NOT IN (
  SELECT MIN(id)
  FROM shulesoft.payments where schema_name='annagamazo'
  GROUP BY uuid
);

#tool to check if database is well configured
postgresqltuner --ssd

#ip address
51.91.251.252 
75.119.140.177


#getting wifi password
netsh wlan show profile name="network_name" key=clear