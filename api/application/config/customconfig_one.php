<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



/* public key for encrypt AWS JWT token
*/
$config['jwt_public_key'] = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAy7kgZrHJIliQXFJNCGMV
v9HoGJAziKKEAyF8nW7nvLgtulJ7IUMiLzhmTeB74RVrvphM1ALEtk/BdQegMYXl
KFmMKLDLVPlZULje1cQRJHkXV4kcjSOxPslH2M+MzSa6sjN6DX7tfjvihrYdJ+wo
VZFhITjOcUF0d/w2rp3/uelrk85qn8ap7UWkFAWWg+N4v+LuvBNBDLv0Y0dYiAFP
bY06D285xmGrko7eXBlKV6tBXaZ29zWD1JOD8uDAgLRNb2S6hpBHfJdNF+BcVNnR
cdGx2GbBVHHqHMbYisiVZhgVd6KY4N6vYFl3B/sJDXgl9Ek+PKzeCrRPT9D+8Ibf
YQIDAQAB
-----END PUBLIC KEY-----';

/*Generated token will expire in 1 minute for sample code
* Increase this value as per requirement for production
*/
$config['token_timeout'] = 1;
$config['authorization_key'] = 'sparqvenba2018';

/* End of file jwt.php */
/* Location: ./application/config/jwt.php */