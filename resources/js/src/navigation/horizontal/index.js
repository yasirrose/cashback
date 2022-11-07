export default [
    // {
    //     header: 'Dashboard',
    //     icon: 'HomeIcon',
    //     children: [{
    //         title: 'Analytics',
    //         route: 'dashboard-analytics',
    //         icon: 'ActivityIcon',
    //     }, ],
    // },
    // {
    //     header: 'Manage App Setting',
    //     icon: 'SettingsIcon',
    //     children: [{
    //             title: 'App Settings',
    //             route: 'app-settings',
    //             icon: 'LockIcon',
    //         },

    //     ],
    // },
    {
        header: 'My Account',
        icon: 'SettingsIcon',
        children: [{
                title: 'Update Password',
                route: 'update-password',
                icon: 'LockIcon',
            },
            // {
            //     title: 'Update Email Address',
            //     route: 'update-email-address',
            //     icon: 'MailIcon',
            // },
            {
                title: 'Update Profile',
                route: 'update-profile',
                icon: 'UserIcon',
            },
            // {
            //     title: 'Apps',
            //     route: 'apps',
            //     icon: 'PackageIcon',
            // },
            // {
            //     title: 'Logs',
            //     route: 'logs',
            //     icon: 'AlertCircleIcon',
            // },
        ],
    },
    {
        header: 'Manage Users',
        icon: 'UserIcon',
        children: [{
                title: 'User Accounts',
                route: 'user-accounts',
                icon: 'UserIcon',
            },
            // {
            //   title: 'User Imports',
            //   route: 'user-imports',
            //   icon: 'UserIcon',
            // },
            // {
            //   title: 'User Groups',
            //   route: 'user-groups',
            //   icon: 'UserIcon',
            // },
            // {
            //   title: 'Custom User Fields',
            //   route: 'custom-user-fields',
            //   icon: 'UserIcon',
            // },
            // {
            //   title: 'User Logs',
            //   route: 'user-authentication-logs',
            //   icon: 'AlertCircleIcon',
            // },
        ],
    },
    {
        header: 'Manage Cashback',
        icon: 'FileIcon',
        children: [{
                title: 'Cashbacks',
                route: 'cashbacks',
                icon: 'FileIcon',
            },

        ],
    },
    {
        header: 'Manage Store',
        icon: 'PackageIcon',
        children: [{
                title: 'Stores',
                route: 'stores',
                icon: 'PackageIcon',
            },

        ],
    },
    // {
    //   header: 'Contact Us',
    //   icon: 'MailIcon',
    //   children: [
    //     {
    //       title: 'Contact Now',
    //       route: 'contact-us',
    //       icon: 'MailIcon',
    //     },
    //   ]
    // },
]