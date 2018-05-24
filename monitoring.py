import psutil, requests, json, time, sys, socket, platform

# python3.6
# psutil
# pip3

def dsk():
    prt = psutil.disk_partitions()
    df = {}
    for i in prt:
        di = { i.device : {
        'mount_point': i.mountpoint,
        'file_system': i.fstype,
        'total': psutil.disk_usage(i.mountpoint).total,
        'used': psutil.disk_usage(i.mountpoint).used,
        'free': psutil.disk_usage(i.mountpoint).free,
        'percent': psutil.disk_usage(i.mountpoint).percent
        } }
        df = {**df, **di}
    return df

def conStats():
    con = psutil.net_connections()
    stable = 0
    listen = 0
    for i in con:
        cond = i.status
        if cond == 'ESTABLISHED':
            stable += 1
        elif cond == 'LISTEN':
            listen += 1
    return { 'total': len(con), 'stable': stable, 'listen': listen }

def addrs():
    ad = psutil.net_if_addrs()
    fl = {}
    for e in ad.keys():
        for i in ad[e]:
            if i.family == socket.AF_INET:
                sl = { e : i.address }
                fl = {**fl, **sl}
                break
    return fl

def data():

    url = 'https://moni.erik.cat/api/data?api_token=' + sys.argv[1]
    payload = {
        'server': sys.argv[2],
        'os': platform.system(),
        'version': platform.release(),
        'platform': platform.platform(),
        'processor': platform.processor(),
        'node': platform.node(),
        'data': {
            'cpu': {
                'cores': psutil.cpu_count(),
                'percent': psutil.cpu_percent(), # Total
                'frequency': psutil.cpu_freq().current,
                'min_frequency': psutil.cpu_freq().min,
                'max_frequency': psutil.cpu_freq().max
            },
            'mem': { # System
                'total': psutil.virtual_memory().total,
                'available': psutil.virtual_memory().available,
                'used': psutil.virtual_memory().used,
                'percent': psutil.virtual_memory().percent,
                'free': psutil.virtual_memory().free,
            },
            'disks': dsk(),
            'net': conStats(),
            'addresses': addrs(),
            'pids': len(psutil.pids())
        }
    }

    try:
        r = requests.post(url, json = payload, headers = {'Accept': 'application/json'})
        if r.status_code == 200:
            print('Data sent to the server')
        else:
            print(r.json())
            print ('There was an error with the request.')
    except:
        print ('There was an error with the request.')

def main(interval):
    while True:
        d = data()
        time.sleep(interval)

if __name__ == "__main__":
    if len(sys.argv) == 1:
        print('The api_token is missing, please enter the API token as the first parameter')
        sys.exit(0)
    if len(sys.argv) == 2:
        print('The server_name is missing, please enter a server name as a second parameter. It will be created if it did not exist')
        sys.exit(0)
    if len(sys.argv) == 3:
        interval = 60
    elif len(sys.argv) > 3:
        interval = sys.argv[3]
        try:
            interval = int(interval)
        except:
            print('Wrong interval')
            sys.exit(0)
    print('Interval set to ' + str(interval) + ' seconds')
main(interval)
