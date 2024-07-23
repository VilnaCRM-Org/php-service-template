import http from 'k6/http';
import { sleep } from 'k6';

export let options = {
    stages: [
        { duration: '1m', target: 20 },
        { duration: '2m', target: 10 },
        { duration: '1m', target: 0 },
    ],
};

export default function () {
    http.get('http://test.k6.io');
    sleep(1);
}
