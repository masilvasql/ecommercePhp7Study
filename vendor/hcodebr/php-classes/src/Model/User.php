<?php

namespace Hcode\Model;
use \Hcode\DB\Sql;
use \Hcode\Model;

    

class User extends Model{
    const SESSION = "User";
        Public static function login($login, $password){
            $sql = new Sql();
            $results = $sql->select("SELECT * FROM tb_users where deslogin = :LOGIN", array(
                ":LOGIN"=>$login
            ));

            if(count($results) === 0){
                throw new \Exception("Usuário não encontrado ou senha inválida");
            }

            $data = $results[0];

            if(password_verify($password, $data["despassword"])){
                $user = new User();
                $user->setData($data);

                $_SESSION[User::SESSION] = $user->getValues(); // sessão guardada numa constante do php
                
                return $user;

            }else{
                throw new \Exception("Usuário não encontrado ou senha inválida");
            }

        }

        public static function verifyLogin($inAdmin = true){
            if (
                !isset($_SESSION[User::SESSION])
                ||
                !$_SESSION[User::SESSION]
                ||
                !(int)$_SESSION[User::SESSION]["iduser"] > 0
            ){
                header("Location: /admin/login");
                exit;
            }else{
                
            }
        }

        public static function logout(){
            $_SESSION[USER::SESSION] = null;
        }

    }
