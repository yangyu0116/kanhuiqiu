#����Ӧ�ļ����Ƶ�outputĿ¼��outputĿ¼�Ľṹ�������յ���վĿ¼�ṹ 

PUBLIC_PATH=../../../../public

rm -rf output
mkdir output
mkdir output/var
cp -r *.php frame source protocol scheduler utils demo output/
rm -rf `find output -name ".svn" `
