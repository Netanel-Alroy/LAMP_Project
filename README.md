# LAMP Project Hosted on AWS

## Overview:
The project is a web application hosted on AWS, featuring a fruits counter page.  
It utilizes the LAMP stack. It features:

- **Backend**: Developed using PHP.
- **Frontend**: Served via Apache.
- **Database**: Powered by MariaDB.

![App screenshot](https://github.com/user-attachments/assets/18d2001a-70e5-49fe-a0e8-1a5468e9e3c9)

### The Project Includes:

- DNS management with Amazon Route 53.
- SSL/TLS certificate management through AWS Certificate Manager.
- Load balancing of web traffic with an Application Load Balancer (ALB).
- EC2 instances deployed across two Availability Zones (AZs) in public subnets, with a primary EC2 instance in AZ1 and an additional EC2 instance based on a custom AMI in AZ2.
- MariaDB databases deployed across two Availability Zones (AZs) in private subnets, with a primary database in AZ1 and a read replica in AZ2.

***

### Project architecture:

![App_Architecture](https://github.com/user-attachments/assets/23cf7a1d-8a56-454c-992d-8bbaff0eb374)


