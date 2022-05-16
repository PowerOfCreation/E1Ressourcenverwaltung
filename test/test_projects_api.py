import requests
import unittest

root_path = "http://localhost"
api_path = f"{root_path}/api"

class TestProjectsAPI(unittest.TestCase):

    def test_get_users(self):
        response = requests.post(f"{api_path}/projects/employees/", data='{"projectId":"1"}')
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.json(), [{'userId': 1, 'userName': 'Ehrenpflaume'}])
    
    def test_get_users_wrong_arguments(self):
        response = requests.post(f"{api_path}/projects/employees/", data='{"userIds":[1]}')
        self.assertEqual(response.status_code, 500)
        response = requests.post(f"{api_path}/projects/employees/", data='{"projectIds":"1"]}')
        self.assertEqual(response.status_code, 500)
        response = requests.post(f"{api_path}/projects/employees/", data='{"projectIds":"0"]}')
        self.assertEqual(response.status_code, 500)
        response = requests.post(f"{api_path}/projects/employees/", data='{"projectIds":"-1"]}')
        self.assertEqual(response.status_code, 500)
        response = requests.post(f"{api_path}/projects/employees/")
        self.assertEqual(response.status_code, 500)

    def test_add_and_delete_users(self):
        response = requests.put(f"{api_path}/projects/employees/", data='{"projectId":"1", "userIds":[2,3]}')
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.json(), {'success': 'true'})

        response = requests.delete(f"{api_path}/projects/employees/", data='{"projectId":"1", "userIds":[2,3]}')
        self.assertEqual(response.status_code, 200)
        self.assertEqual(response.json(), {'success': 'true'})

    def test_add_and_delete_users_wrong_arguments(self):
        response = requests.put(f"{api_path}/projects/employees/", data='{"projectId":"1"')
        self.assertEqual(response.status_code, 500)
        response = requests.delete(f"{api_path}/projects/employees/", data='{"projectId":"1"')
        self.assertEqual(response.status_code, 500)

if __name__ == '__main__':
    unittest.main()
