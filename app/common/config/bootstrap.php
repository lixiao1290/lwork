<?php
Yii::setAlias('common', dirname(__DIR__));
Yii::setAlias('@frontend', dirname(dirname(__DIR__)) . '/frontend');
Yii::setAlias('@backend', dirname(dirname(__DIR__)) . '/backend');
Yii::setAlias('console', dirname(dirname(__DIR__)) . '/console');
Yii::setAlias('app', dirname(dirname(__DIR__))); // 微信扩展基本命名空间
Yii::setAlias('@public', dirname(dirname(__DIR__)) . '/public');