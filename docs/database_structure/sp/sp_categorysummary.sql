CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_categorysummary`(IN datestart DATE,IN dateend DATE)
BEGIN


SET @sql = NULL;
SELECT
  GROUP_CONCAT(DISTINCT
    CONCAT(
      'CASE WHEN category =''',
      category,
      ''' then amount END AS ',category
    )
  ) INTO @sql
from collection
where posted=1
and deleted =0
and ordate between datestart and dateend
;

SET @query = CONCAT(
"
select 
	t.refid,
    c.*
from transaction t
left join (
	select *
	from (
		select
			orno,
			ordate,
            posted,
			personid,
			",
			@sql,
		" from collection
	) as collection
) as c on t.refid = c.orno
where t.posted=1
and t.deleted = 0
and t.trantype='COLLECTION'
and c.posted=1
and c.ordate  between '", datestart , "' and '", dateend,"'"
);

PREPARE stmt FROM @query;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
    PREPARE stmt  FROM @query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;

END