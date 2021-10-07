
// 스포츠
const PACKET_SPORT_LIST = 0x01;         // 첫 페지로딩시 보내는 파켓코드
const PACKET_SPORT_BET = 0x02;          // 스포츠배팅시 보내는 파켓코드
const PACKET_SPORT_AJAX = 0x03;         // 실시간으로 스포츠자료 가져오는 파켓코드

//Powerball
const PACKET_POWERBALL_TIME = 0x11;     // 파워볼, 파워사다리 마감시간 요청코드
const PACKET_POWERBALL_BET = 0x12;      // 파워볼 배팅 코드

//파워사다리
const PACKET_POWERLADDER_BET = 0x22;    // 파워사다리 배팅 코드

//키노사다리
const PACKET_KENOLADDER_BET = 0x32;     // 키노사다리 배팅 코드

//스포츠 소켓주소
const WS_SPORTS_ADDRESS = "wss://line1111.com:8443";
//const WS_SPORTS_ADDRESS = "ws://211.115.107.195:3002";

//미니게임 소켓주소
// const WS_MINI_ADDRESS = "wss://line1111.com:8443";