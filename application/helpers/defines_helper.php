<?php

CONST FORGOT_REMAIL_TIME = 60; //Şifremi unuttum maili tekrar gönderme timeout süresi 1dk


class RESPONSE_CODE
{

    CONST OK = 200;
    CONST SERVER_ERROR = 500;
    CONST BAD_REQUEST = 400;
    CONST PERMISSION_DENIED = 401;
}

class RESP_MSG_SIGN
{

    CONST OK = "Kayıt Başarılı. Giriş Yapabilirsiniz...";
    CONST OK_TEMP = "Lütfen Mail Adresinize Gönderilen Linke Tıklayınız...";
    CONST OK_DELETE = "Kullanıcı Başarıyla Kaldırılmıştır.";
    CONST ERR_INVALID_EMAIL = "Geçersiz E-posta Adresi";
    CONST ERR_INVALID_VALUE = "Geçersiz E-posta Adresi Veya Şifre";
    CONST ERR_PASSWORD_MATCH = "Girilen Parolalar Eşleşmiyor";
    CONST ERR_PASSWORD_SHORT = "Parola 6 Karakterden Fazla Olmalıdır";
    CONST ERR_MISSING_PARAMS = "Lütfen Tüm Alanları Eksiksiz Doldurun";
    CONST ERR_USING_EMAIL = "Bu E-posta Adresi Kullanılmaktadır";
    CONST ERR_UNKNOWN = "Bir Hata Meydana Geldi...";

    CONST ERR_FORGOTTEN_EMAIL_INVALID = "Geçersiz Mail Adresi";

}

class RESP_MSG_PROFILE
{
    CONST OK = "Bilgileriniz Başarı İle Güncellenmiştir";
    CONST ERR_UNKNOWN = "Bir Hata Meydana Geldi...";
    CONST ERR_FORGOTTEN_OK = "Lütfen Mail Adresinize Gönderilen Linke Tıklayınız";
    CONST ERR_FORGOTTEN_WAIT = "Tekrar Mail Almak için Lütfen Daha Sonrar Tekrar Deneyin";
}



class RESP_MSG_NOTE
{

    CONST OK = "Notunuz Başarıyla Eklenmiştir";
    CONST OK_LIST = "Notlarınız Başarıyla Listelenmiştir.";
    CONST OK_UPDATE = "Notunuz Başarıyla Güncellenmiştir";
    CONST OK_DELETE = "Notunuz Başarıyla Silinmiştir";
    CONST ERR_UNKNOWN = "Bir Hata Meydana Geldi...";
    CONST ERR_INVALID_VALUE = "Geçersiz Değer";

}
class RESP_MSG_USER
{

    CONST OK = "Kullanıcı Başarıyla Eklenmiştir";
    CONST OK_LIST = "Kullanıcılar Başarıyla Listelenmiştir.";
    CONST OK_UPDATE = "Kullanıcı Başarıyla Güncellenmiştir";
    CONST OK_DELETE = "Kullanıcı Başarıyla Silinmiştir";
    CONST ERR_UNKNOWN = "Bir Hata Meydana Geldi...";
    CONST ERR_INVALID_VALUE = "Geçersiz Değer";
    CONST ERR_USER_ADDED = "Bu Kullanıcı Zaten Kayıtlıdır.";

}
class RESP_MSG_USER_BLOCKED
{

    CONST OK = "Kullanıcı Engellenenler Listesine Eklenmiştir.";
    CONST OK_LIST = "Engellenen Kullanıcılar Başarıyla Listelenmiştir.";
    CONST OK_UPDATE = "Engellenen Kullanıcı Başarıyla Güncellenmiştir";
    CONST OK_DELETE = "Engellenen Kullanıcı Başarıyla Silinmiştir";
    CONST ERR_UNKNOWN = "Bir Hata Meydana Geldi...";
    CONST ERR_INVALID_VALUE = "Geçersiz Değer";

}

class RESP_MSG_FORGOT
{

    CONST OK = "Şifreniz Başarı İle Değiştirilmiştir";
    CONST SENDED_MAIL = "Lütfen Mail Adresinize Gönderilen Linke Tıklayınız";
    CONST ERR_WAIT = "Tekrar Mail Almak için Lütfen Daha Sonrar Tekrar Deneyin";
    CONST ERR_PARAMETER = "Parametre Hatası";
    CONST ERR_UNKNOWN = "Bir Hata Meydana Geldi...";
    CONST ERR_INVALID_EMAIL = "Geçersiz Mail Adresi";
}

class RESP_MSG
{

    CONST OK = "Başarılı";
    CONST PERMISSION_DENIED = "Yetkisiz erişim. Giriş yapmalısınız.";
}

