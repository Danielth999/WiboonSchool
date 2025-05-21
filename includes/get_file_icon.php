<?php
function getFileIcon($extension)
{
    $extension = strtolower($extension);
    switch ($extension) {
        case 'pdf':
            return 'fas fa-file-pdf';
        case 'doc':
        case 'docx':
            return 'fas fa-file-word';
        case 'xls':
        case 'xlsx':
            return 'fas fa-file-excel';
        case 'ppt':
        case 'pptx':
            return 'fas fa-file-powerpoint';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'fas fa-file-image';
        case 'zip':
        case 'rar':
        case '7z':
            return 'fas fa-file-archive';
        default:
            return 'fas fa-file';
    }
}

function getFileColor($extension)
{
    $extension = strtolower($extension);
    switch ($extension) {
        case 'pdf':
            return 'text-red-500';
        case 'doc':
        case 'docx':
            return 'text-blue-500';
        case 'xls':
        case 'xlsx':
            return 'text-green-500';
        case 'ppt':
        case 'pptx':
            return 'text-orange-500';
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            return 'text-purple-500';
        case 'zip':
        case 'rar':
        case '7z':
            return 'text-brown-500';
        default:
            return 'text-blue-400';
    }
}