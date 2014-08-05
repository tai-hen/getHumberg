getHumberg
==========


グーグルの画像検索からハンバーグの画像をたくさん集めます

画像検索APIが廃止になっているためajax用の制限がいろいろ
あるところを使っています

画像は個人で楽しむためにご利用ください



get hunberg image from google image search 


cd imageGet

php src/action/image.php "hunberg"

php src/action/image.php "hunberg demi-glace"


#paging

php src/action/image.php "hunberg" 5 10

1 page 8 images

default 1-100 pages (800 images)
 


