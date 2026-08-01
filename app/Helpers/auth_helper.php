<?php

function isAdmin()
{
    return session()->get('role') === 'admin';
}