CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_personprofile`(IN personid INT,IN type VARCHAR(25))
BEGIN

	SET @query = CONCAT('
SELECT 
	
    person.personid as refid,
    person.lname,
    person.fname,
    person.mname,
    person.type,
    person.active,
    person.deleted,
    person.datestarteffectivity,
    person.dateendeffectivity,
	CONCAT(person.lname,", ",person.fname) AS name,
    CONCAT(person_profile.address_street," ",person_profile.address_city) AS address,
    person_profile.*,
    person.personid FROM person
	LEFT JOIN (
		SELECT 
			personid,
            MAX(STATUS) AS status,
            
			MAX(WIFE_LNAME) AS wife_lname,
            MAX(WIFE_FNAME) AS wife_fname,
            MAX(WIFE_MNAME) AS wife_mname,
            MAX(WIFE_CONTACT_MOBILENO) AS wife_contact_mobileno,
            MAX(WIFE_EMAIL) AS wife_email,
            MAX(WIFE_BIRTHDAY) AS wife_birthday,
            
            MAX(CONTACT_MOBILENO) AS contact_mobileno,
            MAX(CONTACT_TELEPHONENO) AS contact_telephoneno,
            MAX(YEAR_MOVED) as year_moved,
            MAX(REPRESENTATIVE) as representative,
            MAX(REPRESENTATIVE_RELATIONSHIP) as representative_relationship,
            MAX(REPRESENTATIVE_CONTACTNO) as representative_contactno,
			MAX(EMAIL) AS email,
			MAX(GENDER) AS gender,
			MAX(ADDRESS_STREET) AS address_street,
			MAX(ADDRESS_CITY) AS address_city,
			MAX(ADDRESS_PROVINCE) AS address_province,
            MAX(BIRTHDAY) AS birthday
		FROM  (
			SELECT
				personid,
                CASE WHEN fieldcode = "STATUS" THEN fieldvalue END AS status,
                CASE WHEN fieldcode = "WIFE_LNAME" THEN fieldvalue END AS wife_lname,
                CASE WHEN fieldcode = "WIFE_FNAME" THEN fieldvalue END AS wife_fname,
                CASE WHEN fieldcode = "WIFE_MNAME" THEN fieldvalue END AS wife_mname,
                CASE WHEN fieldcode = "WIFE_CONTACT_MOBILENO" THEN fieldvalue END AS wife_contact_mobileno,
                CASE WHEN fieldcode = "WIFE_EMAIL" THEN fieldvalue END AS wife_email,
                CASE WHEN fieldcode = "WIFE_BIRTHDAY" THEN fieldvalue END AS wife_birthday,
                
                CASE WHEN fieldcode = "CONTACT_MOBILENO" THEN fieldvalue END AS CONTACT_MOBILENO,
                CASE WHEN fieldcode = "CONTACT_TELEPHONENO" THEN fieldvalue END AS CONTACT_TELEPHONENO,
                CASE WHEN fieldcode = "YEAR_MOVED" THEN fieldvalue END AS YEAR_MOVED,
                CASE WHEN fieldcode = "REPRESENTATIVE" THEN fieldvalue END AS representative,
                CASE WHEN fieldcode = "REPRESENTATIVE_RELATIONSHIP" THEN fieldvalue END AS representative_relationship,
                CASE WHEN fieldcode = "REPRESENTATIVE_CONTACTNO" THEN fieldvalue END AS representative_contactno,
                CASE WHEN fieldcode = "EMAIL" THEN fieldvalue END AS EMAIL,
				CASE WHEN fieldcode = "GENDER" THEN fieldvalue END AS GENDER,
				CASE WHEN fieldcode = "ADDRESS_STREET" THEN fieldvalue END AS ADDRESS_STREET,
				CASE WHEN fieldcode = "ADDRESS_CITY" THEN fieldvalue END AS ADDRESS_CITY,
				CASE WHEN fieldcode = "ADDRESS_PROVINCE" THEN fieldvalue END AS ADDRESS_PROVINCE,
                CASE WHEN fieldcode = "BIRTHDAY" THEN fieldvalue END AS BIRTHDAY
			FROM person_profile    
            WHERE person_profile.active=1
		) AS person
		group by personid
	) person_profile ON person.personid = person_profile.personid
WHERE person.deleted = 0',
IF(personid, CONCAT(' AND person.personid = ',personid),''),
IF(type <> '', CONCAT(" AND person.type = '",type,"'"),''),
' AND CURDATE() BETWEEN datestarteffectivity AND dateendeffectivity
ORDER BY person.personid;

    ');
    PREPARE stmt  FROM @query;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;

END