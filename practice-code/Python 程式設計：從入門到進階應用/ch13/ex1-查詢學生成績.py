import sqlalchemy as sa
dbc = 'mysql+pymysql://root:cococola@localhost:3306'
con = sa.create_engine(dbc)
con.execute('CREATE DATABASE school')
con.execute('USE  school')
sql = """CREATE  TABLE  stu (
    stuid   INTEGER       PRIMARY KEY,
    name   VARCHAR(50)  not null,
    pid     VARCHAR(20)  not null,
    phone   VARCHAR(20)  not null )"""
con.execute(sql)
sql="INSERT INTO stu VALUES (104001,'Claire','B342222','245667')"
con.execute(sql)
sql="INSERT INTO stu VALUES (104002,'John','J224122','222455')"
con.execute(sql)
sql = """CREATE  TABLE  score (
    stuid   INTEGER       not null,
    sem   VARCHAR(50)  not null,
    sub    VARCHAR(20)  not null,
    score   INTEGER  not null )"""
con.execute(sql)
sql="INSERT INTO score VALUES (104001,'1041','CH',95)"
con.execute(sql)
sql="INSERT INTO score VALUES (104001,'1041','EN',83)"
con.execute(sql)
sql="INSERT INTO score VALUES (104002,'1041','CH',65)"
con.execute(sql)
sql="INSERT INTO score VALUES (104002,'1041','EN',96)"
con.execute(sql)
sql="SELECT stu.name,score.sem,score.sub,score.score FROM stu,score WHERE stu.stuid=score.stuid"
result=con.execute(sql)
rows = result.fetchall()
print(rows)
con.execute('DROP  TABLE  stu')
con.execute('DROP  TABLE  score')
con.execute('DROP  DATABASE  school')