# **LAMP Project Hosted on AWS**

## **Overview**

The project is a web application hosted on AWS, featuring a fruits counter page.  
It utilizes the LAMP stack, featuring:

- **Backend**: Developed using PHP.
- **Frontend**: Served via Apache.
- **Database**: Powered by MariaDB.

![App Screenshot](https://github.com/user-attachments/assets/18d2001a-70e5-49fe-a0e8-1a5468e9e3c9)

---

## **The Project Includes**

- **DNS Management**: Configured using **Amazon Route 53**.
- **SSL/TLS Security**: Managed through **AWS Certificate Manager**.
- **Traffic Load Balancing**: Handled by an **Application Load Balancer**.
- **EC2 Instances**:
  - **Primary Instance**: Deployed in **AZ1**.
  - **Additional Instance**: Primary AMI's instance deployed in **AZ2**.
- **Database**:
  - **Primary MariaDB**: Deployed in **AZ1**.
  - **Read Replica**: Deployed in **AZ2** for high availability.

---

## **Project Architecture**

![App_Architecture](https://github.com/user-attachments/assets/1be9c7d6-1f23-42f3-94d9-8dcbe549ba95)
