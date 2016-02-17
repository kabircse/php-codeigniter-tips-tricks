17.02.16
	For removing first and last bracket from ac_ledger_head
	UPDATE ac_ledger_head set alias=REPLACE(alias,'(','') WHERE LEFT(alias,1)=='(';
	SELECT alias FROM ac_ledger_head WHERE alias!="" OR LEFT(alias,1) NOT IN(0,1,2,3,4,5,6,7,8,9)
	SELECT alias FROM ac_ledger_head WHERE LEFT(alias,1) IN(0,1,2,3,4,5,6,7,8,9) LIMIT 1000
	UPDATE ac_ledger_head set alias=REPLACE(alias,')','') WHERE RIGHT(alias,1)=')';
