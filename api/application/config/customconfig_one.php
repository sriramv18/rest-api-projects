<?php if (!defined('BASEPATH')) exit('No direct script access allowed');



/* public key for encrypt AWS JWT token
*/
$config['jwt_public_key'] = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqTsyy4r3nrjumED4To7w
r1rfjMEzL+hcF8OwGm89aHoEzKLZqr12uQw3eK7tVV97QV8aYOi0zUinHlOVx1PM
Dgik5jW8aCBvGM5S6PAZXn3fj59HYtKL0HIQ1cxaoIUVXjRHD/QkcCEZuG5dIxij
8NOCnE+Ip2nVm9WXbKSb/KXuF+p69Osm8VpVz7hpa/Hcf50iOe3R82dpCytUKBX4
eq0HukzvikhFNglSw5GV0pK0syZxvu/ERMg3ja4r9an8fMayVS2YpybtRl6CCCVP
7LKZG/M5n9UutA8GWMFeDw0qcI3kLdo6ijbdpGDUqjs+OY6MBH+uKLrzsqVNTamC
RwIDAQAB
-----END PUBLIC KEY-----';

$config['jwt_public_key_lender_dev'] = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqTsyy4r3nrjumED4To7w
r1rfjMEzL+hcF8OwGm89aHoEzKLZqr12uQw3eK7tVV97QV8aYOi0zUinHlOVx1PM
Dgik5jW8aCBvGM5S6PAZXn3fj59HYtKL0HIQ1cxaoIUVXjRHD/QkcCEZuG5dIxij
8NOCnE+Ip2nVm9WXbKSb/KXuF+p69Osm8VpVz7hpa/Hcf50iOe3R82dpCytUKBX4
eq0HukzvikhFNglSw5GV0pK0syZxvu/ERMg3ja4r9an8fMayVS2YpybtRl6CCCVP
7LKZG/M5n9UutA8GWMFeDw0qcI3kLdo6ijbdpGDUqjs+OY6MBH+uKLrzsqVNTamC
RwIDAQAB
-----END PUBLIC KEY-----';

$config['jwt_public_key_vendor_dev'] = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAqTsyy4r3nrjumED4To7w
r1rfjMEzL+hcF8OwGm89aHoEzKLZqr12uQw3eK7tVV97QV8aYOi0zUinHlOVx1PM
Dgik5jW8aCBvGM5S6PAZXn3fj59HYtKL0HIQ1cxaoIUVXjRHD/QkcCEZuG5dIxij
8NOCnE+Ip2nVm9WXbKSb/KXuF+p69Osm8VpVz7hpa/Hcf50iOe3R82dpCytUKBX4
eq0HukzvikhFNglSw5GV0pK0syZxvu/ERMg3ja4r9an8fMayVS2YpybtRl6CCCVP
7LKZG/M5n9UutA8GWMFeDw0qcI3kLdo6ijbdpGDUqjs+OY6MBH+uKLrzsqVNTamC
RwIDAQAB
-----END PUBLIC KEY-----';



/*Generated token will expire in 1 minute for sample code
* Increase this value as per requirement for production
*/
$config['token_timeout'] = 1;
$config['authorization_key'] = 'sparqvenba2018';

/* End of file jwt.php */
/* Location: ./application/config/jwt.php */