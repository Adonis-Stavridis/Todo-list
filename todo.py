import subprocess
import sys
import signal
import threading
import webbrowser
import time


class Colors:
  HEADER = '\033[95m'
  OKCYAN = '\033[96m'
  OKGREEN = '\033[92m'
  WARNING = '\033[93m'
  ENDC = '\033[0m'
  BOLD = '\033[1m'

# You can change the commands here to fit your environment
# Add sudo in front of commands if needed


class Commands:
  composerInstall1 = 'cd Web/ && composer install && composer dump-autoload'
  composerInstall2 = 'cd Domain/ && composer install && composer dump-autoload'
  npmInstall = 'cd Web/ && npm install'
  dockerComposeUp = 'docker-compose up --build'
  dockerComposeDown = 'docker-compose down'
  phpUnitTest = './vendor/bin/phpunit ./test'


class App:
  host = 'localhost'
  port = '8011'


def main(argv):
  def signal_handler(signal, frame):
    print('\n' + Colors.BOLD + Colors.WARNING +
          "Removing docker-compose services" + Colors.ENDC)
    proc = subprocess.Popen('docker-compose down', shell=True)
    proc.wait()

    print('\n' + Colors.BOLD + Colors.HEADER +
          "Thank you for using our Application" + Colors.ENDC)
    quit()

  signal.signal(signal.SIGINT, signal_handler)

  if (not argv or argv[0] == '-setup'):
    print('\n' + Colors.BOLD + Colors.OKCYAN +
          "Installing composer dependencies" + Colors.ENDC)
    proc = subprocess.Popen(Commands.composerInstall1, shell=True)
    proc.wait()
    proc = subprocess.Popen(Commands.composerInstall2, shell=True)
    proc.wait()

    print('\n' + Colors.BOLD + Colors.OKCYAN +
          "Installing node modules" + Colors.ENDC)
    proc = subprocess.Popen(Commands.npmInstall, shell=True)
    proc.wait()

  if (not argv or argv[0] == '-launch'):
    print('\n' + Colors.BOLD + Colors.OKGREEN +
          "Launching docker-compose services" + Colors.ENDC)
    proc = subprocess.Popen(Commands.dockerComposeUp, shell=True)
    time.sleep(5)
    webbrowser.open(App.host + ':' + App.port, new=0, autoraise=True)
    proc.wait()

    forever = threading.Event()
    forever.wait()

  if (argv and argv[0] == '-doc'):
    webbrowser.open('doc/index.html', new=0, autoraise=True)

  if (argv and argv[0] == '-test'):
    print('\n' + Colors.BOLD + Colors.WARNING +
          "Launching tests" + Colors.ENDC)
    proc = subprocess.Popen(Commands.phpUnitTest, shell=True)
    proc.wait()


if __name__ == "__main__":
  main(sys.argv[1:])
