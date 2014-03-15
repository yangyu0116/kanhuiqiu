#!/bin/bash

OUTPUT_DIR="output"
PRODUCT_DIR="htmlparser"
NONE_USE="$OUTPUT_DIR  sample.php test Makefile build.sh tags"
OUTPUT_FILE=$PRODUCT_DIR".tar.gz"

mkdir -p $OUTPUT_DIR
rm -rf $OUTPUT_DIR/*
mkdir -p $OUTPUT_DIR/$PRODUCT_DIR

for i in `ls`
	do
		boolUse=1
		for j in $NONE_USE
			do
				if [ $j == $i ]
					then
						boolUse=0
						break
				fi
			done
		if [ $boolUse == 1 ]
			then
				cp -r $i $OUTPUT_DIR/$PRODUCT_DIR/
				echo $i
		fi
	done

cd $OUTPUT_DIR

find ./ -name CVS -exec rm -rf {} \;
tar zcvf $OUTPUT_FILE $PRODUCT_DIR/*

rm -rf $PRODUCT_DIR
cd ..



